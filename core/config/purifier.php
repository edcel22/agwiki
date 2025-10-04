<?php

/**
 * Ok, glad you are here
 * first we get a config instance, and set the settings
 * $config = HTMLPurifier_Config::createDefault();
 * $config->set('Core.Encoding', $this->config->get('purifier.encoding'));
 * $config->set('Cache.SerializerPath', $this->config->get('purifier.cachePath'));
 * if ( ! $this->config->get('purifier.finalize')) {
 *     $config->autoFinalize = false;
 * }
 * $config->loadArray($this->getConfig());
 *
 * You must NOT delete the default settings
 * anything in settings should be compacted with params that needed to instance HTMLPurifier_Config.
 *
 * @link http://htmlpurifier.org/live/configdoc/plain.html
 */

return [
    'encoding'      => 'UTF-8',
    'finalize'      => true,
    'cachePath'     => storage_path('app/purifier'),
    'cacheFileMode' => 0755,
    'settings'      => [
        'default' => [
            'HTML.Doctype'             => 'HTML 4.01 Transitional',
            'HTML.Allowed'             => 'div,b,strong,i,em,u,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]',
            'CSS.AllowedProperties'    => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
            'AutoFormat.AutoParagraph' => true,
            'AutoFormat.RemoveEmpty'   => true,
        ],
        'test'    => [
            'Attr.EnableID' => 'true',
        ],
        "youtube" => [
            "HTML.SafeIframe"      => 'true',
            "URI.SafeIframeRegexp" => "%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/)%",
        ],
        'custom_definition' => [
            'id'  => 'html5-definitions',
            'rev' => 1,
            'debug' => false,
            'elements' => [
                // http://developers.whatwg.org/sections.html
                ['section', 'Block', 'Flow', 'Common'],
                ['nav',     'Block', 'Flow', 'Common'],
                ['article', 'Block', 'Flow', 'Common'],
                ['aside',   'Block', 'Flow', 'Common'],
                ['header',  'Block', 'Flow', 'Common'],
                ['footer',  'Block', 'Flow', 'Common'],

                // Content model actually excludes several tags, not modelled here
                ['address', 'Block', 'Flow', 'Common'],
                ['hgroup', 'Block', 'Required: h1 | h2 | h3 | h4 | h5 | h6', 'Common'],

                // http://developers.whatwg.org/grouping-content.html
                ['figure', 'Block', 'Optional: (figcaption, Flow) | (Flow, figcaption) | Flow', 'Common'],
                ['figcaption', 'Inline', 'Flow', 'Common'],

                // http://developers.whatwg.org/the-video-element.html#the-video-element
                ['video', 'Block', 'Optional: (source, Flow) | (Flow, source) | Flow', 'Common', [
                    'src' => 'URI',
                    'type' => 'Text',
                    'width' => 'Length',
                    'height' => 'Length',
                    'poster' => 'URI',
                    'preload' => 'Enum#auto,metadata,none',
                    'controls' => 'Bool',
                ]],
                ['source', 'Block', 'Flow', 'Common', [
                    'src' => 'URI',
                    'type' => 'Text',
                ]],

                // http://developers.whatwg.org/text-level-semantics.html
                ['s',    'Inline', 'Inline', 'Common'],
                ['var',  'Inline', 'Inline', 'Common'],
                ['sub',  'Inline', 'Inline', 'Common'],
                ['sup',  'Inline', 'Inline', 'Common'],
                ['mark', 'Inline', 'Inline', 'Common'],
                ['wbr',  'Inline', 'Empty', 'Core'],

                // http://developers.whatwg.org/edits.html
                ['ins', 'Block', 'Flow', 'Common', ['cite' => 'URI', 'datetime' => 'CDATA']],
                ['del', 'Block', 'Flow', 'Common', ['cite' => 'URI', 'datetime' => 'CDATA']],
            ],
            'attributes' => [
                ['iframe', 'allowfullscreen', 'Bool'],
                ['table', 'height', 'Text'],
                ['td', 'border', 'Text'],
                ['th', 'border', 'Text'],
                ['tr', 'width', 'Text'],
                ['tr', 'height', 'Text'],
                ['tr', 'border', 'Text'],
            ],
        ],
        'custom_attributes' => [
            ['a', 'target', 'Enum#_blank,_self,_target,_top'],
        ],
        'custom_elements' => [
            ['u', 'Inline', 'Inline', 'Common'],
        ],
    ],
    'profiles' => [
        // 'link_preview' => [
        //     'HTML.SafeIframe' => true,
        //     'URI.SafeIframeRegexp' => '%^(https?:)?//('
        //         . '([a-z0-9-]+\.)?youtube\.com/|'         // www.youtube.com/embed/...
        //         . 'youtu\.be/|'                           // short links (in case)
        //         . 'player\.vimeo\.com/|'                  // Vimeo
        //         . '([a-z0-9-]+\.)?dailymotion\.com/|'     // Dailymotion
        //         . '([a-z0-9-]+\.)?tiktok\.com/|'          // TikTok
        //         . '([a-z0-9-]+\.)?instagram\.com/|'       // Instagram /embed/
        //         . '([a-z0-9-]+\.)?facebook\.com/|'        // FB video plugin
        //         . 'twitframe\.com/'                       // X/Twitter proxy
        //         . ')%ix',
        //     'HTML.Allowed' => 'div,p,br,span,a,img,iframe,h1,h2,h3,h4,h5,h6',
        //     'CSS.AllowedProperties' => 'width,height,min-height',
        //     'Attr.AllowedFrameTargets' => ['_blank'],
        //     'HTML.TargetBlank' => true,
        //     'AutoFormat.AutoParagraph' => false,
        //     'AutoFormat.RemoveEmpty' => true,
        // ],
        'link_preview' => [
            'HTML.Doctype'           => 'HTML5',
            'Core.Encoding'          => 'UTF-8',
            'HTML.SafeIframe'        => true,
            'URI.DisableExternalResources' => false,
            'URI.DisableResources'   => false,

            // allow only the players you render (adjust as needed)
            'URI.SafeIframeRegexp'   =>
            '%^(https?:)?//('
                . 'www\.youtube\.com/embed/|youtube\.com/embed/|'
                . 'player\.vimeo\.com/video/|'
                . 'www\.dailymotion\.com/embed/video/|dailymotion\.com/embed/video/|'
                . 'www\.tiktok\.com/embed/|tiktok\.com/embed/|'
                . 'www\.instagram\.com/.+/embed/|instagram\.com/.+/embed/|'
                . 'www\.facebook\.com/plugins/video\.php|facebook\.com/plugins/video\.php|'
                . 'twitframe\.com/show'
                . ')%',

            // allow common iframe attrs used by your renderer
            'HTML.AllowedElements'   => 'a, p, br, div, h1, h2, h3, img, span, iframe',
            'HTML.AllowedAttributes' => implode(',', [
                // links
                'a.href',
                'a.target',
                'a.rel',
                // images
                'img.src',
                'img.alt',
                'img.title',
                'img.width',
                'img.height',
                'img.style',
                // div/span/p/h*
                'div.class',
                'div.style',
                'span.class',
                'span.style',
                'p.class',
                'p.style',
                'h2.class',
                // iframe
                'iframe.src',
                'iframe.width',
                'iframe.height',
                'iframe.frameborder',
                'iframe.allowfullscreen',
                'iframe.title',
                'iframe.style',
                'iframe.allow',
                'iframe.referrerpolicy',
            ]),

            // optional: allow target="_blank" safely
            'Attr.AllowedFrameTargets' => ['_blank', '_self'],

            // optional hardening
            'HTML.Trusted'           => true,
            'Cache.SerializerPath'   => storage_path('purifier'),
        ],
    ],


];
