<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class OpenGraphController extends Controller
{
    /**
     * Serve Open Graph meta tags for social media crawlers
     * This controller has NO middleware or authentication
     */
    public function show($postId)
    {
        // Find the post without any authentication checks
        $post = Post::find($postId);
        
        if (!$post) {
            abort(404);
        }

        // Generate clean Open Graph meta tags
        $og_title = 'AgWiki Post';
        $og_description = 'Check out this post on AgWiki';
        $og_image = '';
        $tw_image = '';

        if ($post->scrabingcontent != '') {
            // Extract title from scraped content
            $d = new \DOMDocument();
            @$d->loadHTML($post->scrabingcontent);
            
            foreach($d->getElementsByTagName('h1') as $item){
                $og_title = $item->textContent;
                break;
            }
            
            if($og_title == 'AgWiki Post') {
                foreach($d->getElementsByTagName('h2') as $item){
                    $og_title = $item->textContent;
                    break;
                }
            }

            // Extract description
            $og_description = strip_tags($post->scrabingcontent);
            if (strlen($og_description) > 200) {
                $og_description = substr($og_description, 0, 200) . '...';
            }

            // Extract image
            preg_match_all('/<img[^>]+>/i', $post->scrabingcontent, $imgTags);
            if (!empty($imgTags[0])) {
                preg_match('/src="([^"]+)/i', $imgTags[0][0], $imgage);
                if (!empty($imgage[1])) {
                    $og_image = $imgage[1];
                    if (strpos($og_image, 'http') !== 0) {
                        $og_image = 'https://' . $_SERVER['SERVER_NAME'] . '/' . ltrim($og_image, '/');
                    }
                }
            }
        } else {
            // Use post content as fallback
            $og_title = strip_tags(substr($post->content, 0, 60));
            $og_description = strip_tags(substr($post->content, 0, 100));
        }

        // Ensure we have valid content
        if (empty($og_title) || $og_title == 'AgWiki Post') {
            $og_title = $post->user->name . ' - AgWiki Post';
        }
        
        if (empty($og_description)) {
            $og_description = 'Check out this post shared by ' . $post->user->name . ' on AgWiki';
        }
        
        if (empty($og_image)) {
            $og_image = 'https://' . $_SERVER['SERVER_NAME'] . '/assets/front/img/logo_md.png';
        }

        // Ensure URLs are absolute
        if (!empty($og_image) && strpos($og_image, 'http') !== 0) {
            $og_image = 'https://' . $_SERVER['SERVER_NAME'] . '/' . ltrim($og_image, '/');
        }

        $tw_image = $og_image;
        $og_url = route('openGraph', $post->id);
        $page_title = $og_title;

        // Return a minimal view with only the essential Open Graph meta tags
        return view('open-graph', compact('post', 'page_title', 'og_title', 'og_description', 'og_url', 'og_image', 'tw_image'));
    }
}
