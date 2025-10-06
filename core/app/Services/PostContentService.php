<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostContentService
{
    /**
     * Controller calls this and gets the FINAL payload fields to persist.
     * No processing needed in controller.
     */
    public function prepareForStore(Request $request, \App\Services\LinkPreviewService $previewer): array
    {
        $link         = (string) $request->input('link', '');
        $rawCaption   = (string) $request->input('content', '');
        $isLinkType   = $request->has('is_link_type') ? $this->toBoolean($request->input('is_link_type')) : false;

        // Clean the caption (remove pasted URLs / same link)
        $cleanCaption = $this->cleanCaption($rawCaption, $link);

        // Build scrabingcontent with the cleaned caption injected
        $scrabingcontent = null;
        if ($isLinkType && $link !== '') {
            $scrabingcontent = $this->crawlAndRender($link, $previewer, $cleanCaption);
        }

        return [
            'content'         => $cleanCaption,
            'link'            => $link,
            'scrabingcontent' => $scrabingcontent,
        ];
    }

    /**
     * Used by GET/POST /getLinkPreview endpoint. Returns final HTML.
     */
    public function previewForLink(Request $request, \App\Services\LinkPreviewService $previewer): ?string
    {
        $link       = (string) $request->input('link', '');
        $rawCaption = (string) $request->input('caption', '');
        $clean      = $this->cleanCaption($rawCaption, $link);

        return $this->crawlAndRender($link, $previewer, $clean);
    }

    // -------------------- helpers (internal) --------------------

    private function toBoolean($value)
    {
        if (is_bool($value)) return $value;
        if (is_int($value) || is_float($value)) return ((int)$value) === 1;

        $v = strtolower(trim((string)$value));
        if ($v === '') return false;

        if (in_array($v, ['1','true','on','yes','y'], true)) return true;
        if (in_array($v, ['0','false','off','no','n'], true)) return false;

        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    private function cleanCaption($caption, $link = null)
    {
        $c = trim((string) $caption);
        if ($c === '') return '';

        if (!empty($link)) {
            $patternExact = '~' . preg_quote($link, '~') . '~i';
            $c = preg_replace($patternExact, '', $c);
        }

        // Strip any remaining naked URLs
        $c = preg_replace('~\bhttps?://[^\s<>"\']+~i', '', $c);

        // Collapse whitespace
        $c = preg_replace('~\s{2,}~', ' ', $c);
        return trim($c);
    }

    private function crawlAndRender(string $url, \App\Services\LinkPreviewService $previewer, ?string $caption = null): ?string
    {
        try {
            $preview = $previewer->fetch($url);
            if (empty($preview['ok'])) return null;

            $rawHtml  = \App\Support\LinkPreviewRenderer::render($preview, $url);
            $massaged = $this->massagePreviewHtml($rawHtml, $url, $caption);

            // If you sanitize with Purifier, use your allowlist profile:
            // return \Purifier::clean($massaged, 'link_preview');
            return $massaged;
        } catch (\Throwable $e) {
            Log::warning('link-preview-failed', ['url' => $url, 'ex' => $e->getMessage()]);
            return null;
        }
    }

    private function massagePreviewHtml(string $html, string $url, ?string $caption = null): string
    {
        // Convert <h1> to clickable <h2>
        $html = preg_replace_callback('~<h1>(.*?)</h1>~is', function ($m) use ($url) {
            return '<h2><a href="/ajaxpage?url=' . e($url) . '" rel="modal:open">' . $m[1] . '</a></h2>';
        }, $html);

        // Make anchors open your modal
        $html = preg_replace_callback(
            '~<a\s+[^>]*href\s*=\s*"[^"]*"[^>]*>~i',
            function ($m) use ($url) {
                $tag = $m[0];
                $tag = preg_replace(['~\s+target="[^"]*"~i', '~\s+rel="[^"]*"~i'], '', $tag);
                $tag = preg_replace('~href="[^"]*"~i', 'href="/ajaxpage?url=' . e($url) . '"', $tag);
                if (stripos($tag, 'rel=') === false) {
                    $tag = rtrim($tag, '>') . ' rel="modal:open">';
                }
                return $tag;
            },
            $html
        );

        // Ensure iframe style
        $html = preg_replace_callback('~<iframe[^>]*>~i', function ($m) {
            $tag = $m[0];
            if (stripos($tag, 'style=') === false) {
                $tag = rtrim($tag, '>') . ' style="width:100%;min-height:300px;">';
            }
            return $tag;
        }, $html);

        // Inject cleaned caption into <p class="linkContent">...</p>
        if (!empty($caption)) {
            $injected = '<p class="linkContent">' . e($caption) . '</p>';

            // Replace existing empty placeholder first
            $replaced = preg_replace('~<p\s+class="linkContent">\s*</p>~i', $injected, $html, 1);
            if ($replaced !== null && $replaced !== $html) {
                $html = $replaced;
            } else {
                // If placeholder not present, insert after the opening wrapper
                $html = preg_replace(
                    '~(<div\s+class="col-md-12[^"]*".*?>)~i',
                    '$1' . $injected,
                    $html,
                    1
                );
            }
        }

        return $html;
    }
}
