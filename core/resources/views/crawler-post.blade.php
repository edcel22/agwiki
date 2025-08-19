<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title }} | AgWiki</title>
    
    <!-- Essential Open Graph Meta Tags for Social Media -->
    <meta property="og:title" content="{{ $og_title }}" />
    <meta property="og:description" content="{{ $og_description }}" />
    <meta property="og:url" content="{{ $og_url }}" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="{{ $og_image }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:site_name" content="AgWiki" />
    <meta property="og:locale" content="en_US" />
    
    <!-- LinkedIn specific meta tags -->
    <meta property="article:author" content="{{ $post->user->name }}" />
    @if(isset($post->created_at) && $post->created_at)
        <meta property="article:published_time" content="{{ $post->created_at->toISOString() }}" />
    @endif
    @if(isset($post->updated_at) && $post->updated_at)
        <meta property="article:modified_time" content="{{ $post->updated_at->toISOString() }}" />
    @endif
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $og_title }}" />
    <meta name="twitter:description" content="{{ $og_description }}" />
    <meta name="twitter:image" content="{{ $tw_image }}" />
    
    <!-- Additional Meta Tags -->
    <meta name="description" content="{{ $og_description }}" />
    <meta name="robots" content="index, follow" />
    
    <!-- Prevent indexing of this crawler page -->
    <meta name="robots" content="noindex, nofollow" />
</head>
<body>
    <!-- Minimal content for crawlers -->
    <div style="display: none;">
        <h1>{{ $og_title }}</h1>
        <p>{{ $og_description }}</p>
        <img src="{{ $og_image }}" alt="{{ $og_title }}" />
        <p>Shared by {{ $post->user->name }} on AgWiki</p>
        <p>View the full post at: <a href="{{ route('user.post.single', $post->id) }}">{{ route('user.post.single', $post->id) }}</a></p>
    </div>
    
    <!-- Redirect to actual post for human users -->
    <script>
        // Only redirect if this is not a social media crawler
        if (!/facebookexternalhit|LinkedInBot|Twitterbot|WhatsApp|TelegramBot|Slackbot|Discordbot/i.test(navigator.userAgent)) {
            window.location.href = '{{ route('user.post.single', $post->id) }}';
        }
    </script>
    
    <noscript>
        <meta http-equiv="refresh" content="0;url={{ route('user.post.single', $post->id) }}">
    </noscript>
</body>
</html>
