<?php

namespace App\Support;

class LinkPreviewRenderer
{
  // keep untyped for older PHP
  protected static $iframeHosts = array(
    // YouTube
    'www.youtube.com',
    'youtube.com',
    // Vimeo
    'player.vimeo.com',
    // Dailymotion
    'www.dailymotion.com',
    'dailymotion.com',
    // TikTok
    'www.tiktok.com',
    'tiktok.com',
    // Instagram (their embeds render from same host)
    'www.instagram.com',
    'instagram.com',
    // Facebook video plugin
    'www.facebook.com',
    'facebook.com',
    // X (Twitter) via twitframe proxy
    'twitframe.com',
    // Optional: add more CDNs/players if you need them later
  );

  /**
   * Build preview HTML for any URL.
   * Falls back to constructing known embed URLs when no `player` meta is present.
   *
   * @param array  $preview     // title, description, image, site_name, player (optional)
   * @param string $originalUrl
   * @return string
   */
  public static function render($preview, $originalUrl)
  {
    $esc = function ($v) {
      if (function_exists('e')) return e($v);
      return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
    };

    $title  = isset($preview['title']) ? $preview['title'] : parse_url($originalUrl, PHP_URL_HOST);
    $desc   = isset($preview['description']) ? $preview['description'] : '';
    $image  = isset($preview['image']) ? $preview['image'] : null;
    $site   = isset($preview['site_name']) ? $preview['site_name'] : parse_url($originalUrl, PHP_URL_HOST);
    $player = isset($preview['player']) ? $preview['player'] : null;

    $html  = '<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12"><p class="linkContent"></p><div class="guteurlsBox">';

    if ($player) {
      $html .= '<div class="guteurlsVideo">
                        <iframe frameborder="0" allowfullscreen="1" title="YouTube video player"
                                src="' . $esc($player) . '"
                                style="width: 100%; min-height: 300px;"></iframe>
                      </div>';
    } elseif ($image) {
      $html .= '<div class="article-img"><img src="' . $esc($image) . '" alt="' . $esc($site) . '" style="height:auto;" /></div>';
    } else {
      $html .= '<div class="guteurlsVideo"></div>';
    }

    $html .= '<h2><a href="' . $esc($originalUrl) . '" target="_blank" rel="noreferrer noopener">' . $esc($title) . '</a></h2>';

    if (!empty($desc)) {
      $html .= '<p>' . $esc($desc) . '</p>';
    }

    $html .= '</div><a href="' . $esc($originalUrl) . '" target="_blank" class="pull-right readmore" rel="noreferrer noopener">Read More</a><br /></div>';

    return $html;
  }

  // ----------------- helpers -----------------

  protected static function isAllowedIframe($playerUrl)
  {
    $host = parse_url($playerUrl, PHP_URL_HOST);
    if (!$host) return false;
    $host = strtolower($host);

    foreach (self::$iframeHosts as $allowed) {
      if ($host === $allowed || self::endsWith($host, '.' . $allowed)) return true;
    }
    return false;
  }

  private static function endsWith($haystack, $needle)
  {
    $len = strlen($needle);
    if ($len === 0) return true;
    return substr($haystack, -$len) === $needle;
  }

  // ---- provider ID / embed builders (simple and robust)

  private static function youtubeId($url)
  {
    if (preg_match('~youtu\.be/([A-Za-z0-9_-]{6,})~', $url, $m)) return $m[1];
    if (preg_match('~[?&]v=([A-Za-z0-9_-]{6,})~', $url, $m)) return $m[1];
    if (preg_match('~youtube\.com/shorts/([A-Za-z0-9_-]{6,})~', $url, $m)) return $m[1];
    return null;
  }

  private static function vimeoId($url)
  {
    if (preg_match('~vimeo\.com/(?:video/)?([0-9]+)~', $url, $m)) return $m[1];
    return null;
  }

  private static function dailymotionId($url)
  {
    if (preg_match('~dailymotion\.com/video/([A-Za-z0-9]+)~', $url, $m)) return $m[1];
    return null;
  }

  private static function tiktokId($url)
  {
    // /@user/video/ID  or /video/ID
    if (preg_match('~/video/([0-9]+)~', $url, $m)) return $m[1];
    return null;
  }

  private static function instagramEmbedUrl($url)
  {
    // posts: /p/<code>, reels: /reel/<code>
    if (preg_match('~instagram\.com/(p|reel)/([A-Za-z0-9_-]+)/?~', $url, $m)) {
      return 'https://www.instagram.com/' . $m[1] . '/' . $m[2] . '/embed/';
    }
    return null;
  }

  private static function facebookEmbedUrl($url)
  {
    // works for /watch/?v=ID, /videos/ID, or permalink video urls
    $encoded = rawurlencode($url);
    // FB official embed endpoint:
    return 'https://www.facebook.com/plugins/video.php?href=' . $encoded . '&show_text=0';
  }

  private static function isTwitterUrl($url)
  {
    return (bool) preg_match('~(twitter\.com|x\.com)/[^/]+/status/\d+~i', $url);
  }
}
