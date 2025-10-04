<?php

namespace App\Services;

use GuzzleHttp\Client;
use DOMDocument;
use DOMXPath;

class LinkPreviewService
{
    public function fetch(string $url): array
    {
        $client = new Client([
            'timeout' => 8.0,
            'headers' => [
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

        // Parse DOM
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($doc);

        // Helpers
        $meta = function(string $property, bool $isName = false) use ($xpath) {
            $attr = $isName ? 'name' : 'property';
            $node = $xpath->query("//meta[@{$attr}='{$property}']/@content")->item(0);
            return $node ? trim($node->nodeValue) : null;
        };
        $firstText = function(string $query) use ($xpath) {
            $node = $xpath->query($query)->item(0);
            return $node ? trim($node->textContent) : null;
        };
        $firstAttr = function(string $query, string $attr) use ($xpath) {
            $node = $xpath->query($query)->item(0);
            return $node ? trim($node->getAttribute($attr)) : null;
        };

        // Prefer Open Graph
        $title       = $meta('og:title') ?: $meta('twitter:title', true) ?: $firstText('//title');
        $description = $meta('og:description') ?: $meta('description', true) ?: $meta('twitter:description', true);
        $image       = $meta('og:image') ?: $meta('twitter:image', true) ?: $firstAttr('//img[1]', 'src');
        $siteName    = $meta('og:site_name') ?: parse_url($url, PHP_URL_HOST);
        $type        = $meta('og:type');
        $favicon     = $firstAttr("//link[@rel='icon' or @rel='shortcut icon'][1]", 'href');

        // NEW: try to get a player from meta
        $player = $meta('og:video') ?: $meta('og:video:url') ?: $meta('twitter:player', true);

        // Normalize relative URLs
        $normalizeUrl = function($maybeUrl) use ($url) {
            if (!$maybeUrl) return null;
            if (preg_match('#^https?://#i', $maybeUrl)) return $maybeUrl;
            if (strpos($maybeUrl, '//') === 0) {
                $scheme = parse_url($url, PHP_URL_SCHEME) ?: 'https';
                return $scheme . ':' . $maybeUrl;
            }
            $base = rtrim($url, '/');
            if ($maybeUrl[0] === '/') {
                $parts = parse_url($url);
                return ($parts['scheme'] ?? 'https') . '://' . $parts['host'] . $maybeUrl;
            }
            return $base . '/' . ltrim($maybeUrl, '/');
        };

        $image   = $normalizeUrl($image);
        $favicon = $normalizeUrl($favicon);
        $player  = $normalizeUrl($player);

        // NEW: if no meta player, build one from the URL for common providers
        if (!$player) {
            if ($yt = $this->youtubeId($url)) {
                $player = "https://www.youtube.com/embed/{$yt}?rel=0&showinfo=0";
            } elseif ($vm = $this->vimeoId($url)) {
                $player = "https://player.vimeo.com/video/{$vm}";
            } elseif ($dm = $this->dailymotionId($url)) {
                $player = "https://www.dailymotion.com/embed/video/{$dm}";
            } elseif ($tt = $this->tiktokId($url)) {
                $player = "https://www.tiktok.com/embed/v2/{$tt}";
            } elseif ($ig = $this->instagramEmbedUrl($url)) {
                $player = $ig; // already an /embed/ URL
            } elseif ($this->isTwitterUrl($url)) {
                $player = 'https://twitframe.com/show?url=' . rawurlencode($url);
            } elseif ($this->isFacebookUrl($url)) {
                $player = 'https://www.facebook.com/plugins/video.php?href=' . rawurlencode($url) . '&show_text=0';
            }
        }

        return [
            'ok'         => true,
            'url'        => $url,
            'title'      => $title,
            'description'=> $description,
            'image'      => $image,
            'site_name'  => $siteName,
            'type'       => $type,
            'favicon'    => $favicon,
            'player'     => $player, // NEW
        ];
    }

    // ------- provider helpers (PHP 7 friendly) -------
    private function youtubeId($url)
    {
        if (preg_match('~youtu\.be/([A-Za-z0-9_-]{6,})~', $url, $m)) return $m[1];
        if (preg_match('~youtube\.com/shorts/([A-Za-z0-9_-]{6,})~', $url, $m)) return $m[1];
        if (preg_match('~[?&]v=([A-Za-z0-9_-]{6,})~', $url, $m)) return preg_replace('~[^A-Za-z0-9_-].*$~', '', $m[1]);
        return null;
    }
    private function vimeoId($url)
    {
        if (preg_match('~vimeo\.com/(?:video/)?([0-9]+)~', $url, $m)) return $m[1];
        return null;
    }
    private function dailymotionId($url)
    {
        if (preg_match('~dailymotion\.com/video/([A-Za-z0-9]+)~', $url, $m)) return $m[1];
        return null;
    }
    private function tiktokId($url)
    {
        if (preg_match('~/video/([0-9]+)~', $url, $m) && preg_match('~tiktok\.com~i', $url)) return $m[1];
        return null;
    }
    private function instagramEmbedUrl($url)
    {
        if (preg_match('~instagram\.com/(p|reel)/([A-Za-z0-9_-]+)/?~', $url, $m))
            return 'https://www.instagram.com/'.$m[1].'/'.$m[2].'/embed/';
        return null;
    }
    private function isTwitterUrl($url)
    {
        return (bool) preg_match('~(twitter\.com|x\.com)/[^/]+/status/\d+~i', $url);
    }
    private function isFacebookUrl($url)
    {
        return (bool) preg_match('~facebook\.com~i', $url);
    }
}
