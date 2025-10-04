<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mews\Purifier\Facades\Purifier;
use App\Interest;
use App\Post;
use App\Services\LinkPreviewService;
use App\Share;
use App\Support\LinkPreviewRenderer;
use App\User;
use App\UserToken;


class PostController extends Controller
{
    public function store(Request $request, LinkPreviewService $previewer)
    {
        $validator = \Validator::make($request->all(), [
            'app_token'    => 'required',
            'type'         => 'required|in:article,image,link',
            'is_link_type'   => 'sometimes|boolean',
            'link'         => 'required|url', // image, docs, url links
            'content'      => 'required_unless:is_link_type,1|nullable|string',
            'interest'     => 'sometimes|array',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 400);
        }

        $userToken = UserToken::where('token', $request->input('app_token'))->first();
        if (!$userToken) {
            return response()->json(['error' => 'Invalid or missing app token.'], 401);
        }
        $user = $userToken->user;

        $isPostLinkType = isset($request->is_link_type) && $request->is_link_type;
        $scrabingcontent = null;

        if ($isPostLinkType && $request->filled('link')) {
            $scrabingcontent = $this->crawlAndRender($request->link, $previewer);
        }

        $created_post = Post::create([
            'user_id'        => $user->id,
            'content'        => $request->input('content', ''),    // caption or empty
            'type'           => $request->input('type'),           // 'link' | 'article' | 'image'
            'from_api'       => true,
            'link'           => $isPostLinkType ? $request->input('link') : $request->input('link', ''),
            'scrabingcontent' => $scrabingcontent,
        ]);

        if ($request->filled('interest')) {
            $created_post->interests()->attach($request->interest);
        }

        Share::create([
            'post_id'  => $created_post->id,
            'user_id'  => $user->id,
            'group_id' => 0,
        ]);

        return response([
            'record' => $created_post,
            // optionally also return the rendered HTML so FE can render instantly:
            'html'   => $scrabingcontent,
        ]);
    }

    public function getLinkPreview(Request $request, LinkPreviewService $previewer)
    {

        $validator = \Validator::make($request->all(), [
            'app_token'    => 'required',
            'link'         => 'required|url', // image, docs, url links
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 400);
        }

        $userToken = UserToken::where('token', $request->input('app_token'))->first();
        if (!$userToken) {
            return response()->json(['error' => 'Invalid or missing app token.'], 401);
        }

        $scrabingcontent = $this->crawlAndRender($request->link, $previewer);

        return $scrabingcontent;
    }

    public function getInterests(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $interestIds = $request->input('interestIds', []);
        $interests = Interest::query()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($interestIds, function ($query, $interestIds) {
                return $query->orWhereIn('id', $interestIds);
            })
            ->orderBy('name', 'asc')
            ->limit(20)
            ->get();

        return response([
            'interests' => $interests,
        ]);
    }

    public function destroy(Request $request, Post $post)
    {
        $validator = \Validator::make($request->all(), [
            'app_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $appToken = $request->input('app_token');
        $userToken = UserToken::where('token', $appToken)->first();

        if (!$userToken) {
            return response()->json(['error' => 'Invalid or missing app token.'], 401);
        }

        // check if post matches the account
        // $post = Post::where('post_id', $request->post_id);

        if (!$post) {
            return response([
                'errors' => ['Post does not exist']
            ], 400);
        }

        if ($userToken->user->id != $post->user_id) {
            return response([
                'errors' => ['You are not allowed to delete this post.']
            ], 400);
        }

        if (!$post->from_api) {
            return response([
                'errors' => ['You cannot delete post that are not posted from api.']
            ], 400);
        }

        $sharePost = Share::where('post_id', $request->post_id)->first();
        if ($sharePost) {
            $sharePost->delete();
        }
        $post->delete();

        return response([
            'message' => 'Post deleted successfully.'
        ]);
    }

    private function crawlAndRender(string $url, \App\Services\LinkPreviewService $previewer): ?string
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
    private function massagePreviewHtml(string $html, string $url): string
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
