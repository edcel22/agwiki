<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class PostContentService
{
  public function crawlAndRender(string $url, \App\Services\LinkPreviewService $previewer): ?string
  {
    try {
      // 1) fetch meta (og:title/desc/image + player fallbacks)
      $preview = $previewer->fetch($url);
      if (empty($preview['ok'])) {
        return null;
      }

      // 2) build preview block (image or iframe + title/desc)
      $rawHtml = \App\Support\LinkPreviewRenderer::render($preview, $url);

      // 3) tweak HTML so it behaves like your theme output
      $massaged = $this->massagePreviewHtml($rawHtml, $url);

      // 4) sanitize but allow safe iframes (configure 'link_preview' in config/purifier.php)
      // return \Purifier::clean($massaged, 'link_preview');
      return $massaged;
    } catch (\Throwable $e) {
      // optional: log the error for debugging
      \Log::warning('link-preview-failed', ['url' => $url, 'ex' => $e->getMessage()]);
      return null;
    }
  }

  /**
   * Make links open your internal modal, ensure iframe sizing,
   * and append a "Read More" link—mirrors the legacy GuteURLs behavior.
   */
  public function massagePreviewHtml(string $html, string $url): string
  {
    // Convert any headline <h1>Title</h1> to <h2><a ...>Title</a></h2>
    $html = preg_replace_callback('~<h1>(.*?)</h1>~is', function ($m) use ($url) {
      return '<h2><a href="/ajaxpage?url=' . e($url) . '" rel="modal:open">' . $m[1] . '</a></h2>';
    }, $html);

    // Force anchors to open your modal instead of external windows
    $html = preg_replace_callback(
      '~<a\s+[^>]*href\s*=\s*"[^"]*"[^>]*>~i',
      function ($m) use ($url) {
        $tag = $m[0];
        // strip existing target/rel
        $tag = preg_replace(['~\s+target="[^"]*"~i', '~\s+rel="[^"]*"~i'], '', $tag);
        // point to internal modal
        $tag = preg_replace('~href="[^"]*"~i', 'href="/ajaxpage?url=' . e($url) . '"', $tag);
        // add rel
        if (stripos($tag, 'rel=') === false) {
          $tag = rtrim($tag, '>') . ' rel="modal:open">';
        }
        return $tag;
      },
      $html
    );

    // Ensure iframe has width:100% and min-height:300px if not set
    $html = preg_replace_callback('~<iframe[^>]*>~i', function ($m) {
      $tag = $m[0];
      if (stripos($tag, 'style=') === false) {
        $tag = rtrim($tag, '>') . ' style="width:100%;min-height:300px;">';
      }
      return $tag;
    }, $html);

    // $html .= '<a href="/ajaxpage?url=' . e($url) . '" rel="modal:open" class="pull-right readmore">Read More</a><br>';

    return $html;
  }
}
