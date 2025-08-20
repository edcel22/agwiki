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
    
    <!-- Facebook specific meta tags -->
    <meta property="fb:app_id" content="" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:alt" content="{{ $og_title }}" />
    
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
    <meta name="twitter:image:alt" content="{{ $og_title }}" />
    
    <!-- Additional Meta Tags -->
    <meta name="description" content="{{ $og_description }}" />
    <meta name="robots" content="index, follow" />
    
    <!-- Prevent indexing of this Open Graph page -->
    <meta name="robots" content="noindex, nofollow" />
    
    <!-- Additional social media meta tags -->
    <meta name="author" content="{{ $post->user->name }}" />
    <meta name="publisher" content="AgWiki" />
</head>
<body>
    <!-- Content for crawlers and human users -->
    <div style="padding: 20px; font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto;">
        <h1>{{ $og_title }}</h1>
        <p>{{ $og_description }}</p>
        @if(!empty($og_image))
            <img src="{{ $og_image }}" alt="{{ $og_title }}" style="max-width: 100%; height: auto; margin: 20px 0;" />
        @endif
        <p><strong>Shared by {{ $post->user->name }} on AgWiki</strong></p>
        <p>View the full post at: <a href="{{ route('user.post.single', $post->id) }}">{{ route('user.post.single', $post->id) }}</a></p>
        
        <!-- Additional content for better crawler understanding -->
        <div style="margin-top: 30px; padding: 20px; background-color: #f5f5f5; border-radius: 5px;">
            <h2>About this post</h2>
            <p>This is a post shared on AgWiki, a platform for agricultural knowledge sharing and community building.</p>
            <p>To view the complete post with full content and interact with the community, please visit the link above.</p>
        </div>
    </div>
</body>
</html>
