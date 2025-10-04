<?php

namespace App\Services;

use GuzzleHttp\Client;
use DOMDocument;
use DOMXPath;
use DOMElement;

class LinkPreviewService
{
    public function fetch(string $url): array
    {
        $client = new Client([
            'timeout' => 8.0,
            'headers' => [
                // Replace with your real site so some servers don’t block you:
                'User-Agent' => 'Mozilla/5.0 (compatible; LinkPreviewBot/1.0; +https://app.postingautomation.com)',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            ],
            'allow_redirects' => true,
            'http_errors' => false,
        ]);

        $res = $client->get($url);
        $status = $res->getStatusCode();
        if ($status < 200 || $status >= 400) {
            return ['ok' => false, 'status' => $status];
        }

        $html = (string) $res->getBody();

        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        // helps with some encodings
        $doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $xpath = new DOMXPath($doc);

        // Read <meta ...> content by property= or name=
        $meta = function (string $property, bool $isName = false) use ($xpath) {
            $attr = $isName ? 'name' : 'property';
            // Select the meta element, not the @content node, so we can safely call getAttribute()
            /** @var DOMElement|null $el */
            $el = $xpath->query("//meta[@{$attr}='{$property}']")->item(0);
            return ($el instanceof DOMElement) ? trim((string) $el->getAttribute('content')) : null;
        };

        $firstText = function (string $query) use ($xpath) {
            $node = $xpath->query($query)->item(0);
            return $node ? trim($node->textContent) : null;
        };

        $firstAttr = function (string $query, string $attr) use ($xpath) {
            /** @var DOMElement|null $el */
            $el = $xpath->query($query)->item(0);
            return ($el instanceof DOMElement) ? trim((string) $el->getAttribute($attr)) : null;
        };

        // Prefer Open Graph / Twitter
        $title = $meta('og:title') ?: $meta('twitter:title', true) ?: $firstText('//title');
        $description = $meta('og:description') ?: $meta('description', true) ?: $meta('twitter:description', true);
        $image = $meta('og:image') ?: $meta('twitter:image', true) ?: $firstAttr('//img[1]', 'src');
        $siteName = $meta('og:site_name') ?: (parse_url($url, PHP_URL_HOST) ?: null);
        $type = $meta('og:type');

        // favicon from <link rel="icon|shortcut icon">
        $favicon = $firstAttr("//link[translate(@rel,'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz')='icon' or translate(@rel,'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz')='shortcut icon'][1]", 'href');

        // Normalize relative URLs
        $normalizeUrl = function (?string $maybeUrl) use ($url) {
            if (!$maybeUrl) return null;
            if (preg_match('#^https?://#i', $maybeUrl)) return $maybeUrl;
            if (strpos($maybeUrl, '//') === 0) {
                $scheme = parse_url($url, PHP_URL_SCHEME) ?: 'https';
                return $scheme . ':' . $maybeUrl;
            }
            $parts = parse_url($url);
            $origin = ($parts['scheme'] ?? 'https') . '://' . ($parts['host'] ?? '');
            if (isset($parts['port'])) $origin .= ':' . $parts['port'];
            if ($maybeUrl[0] === '/') {
                return $origin . $maybeUrl;
            }
            $basePath = rtrim(dirname($parts['path'] ?? '/'), '/');
            return $origin . ($basePath ? $basePath : '') . '/' . ltrim($maybeUrl, '/');
        };

        $image = $normalizeUrl($image);
        $favicon = $normalizeUrl($favicon);

        return [
            'ok' => true,
            'url' => $url,
            'title' => $title,
            'description' => $description,
            'image' => $image,
            'site_name' => $siteName,
            'type' => $type,
            'favicon' => $favicon,
        ];
    }
}
