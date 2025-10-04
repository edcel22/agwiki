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
    public function storeV1(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'app_token' => 'required',
            'content' => 'required',
            'link'      => 'required_if:type,link|url', // imageLink or doc link
            'type'      => 'required|in:article,image,link',
            'interest' => 'sometimes|array'
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

        $user = $userToken->user;

        $created_post = Post::create([
            'user_id' => $user->id,
            'content' => $request->content,
            'type' => $request->type,
            'from_api' => true,
            'link' => $request->link,
        ]);
        $created_post->interests()->attach($request->interest);

        $share = Share::create([
            'post_id' => $created_post->id,
            'user_id' => $user->id,
            'group_id' => 0,
        ]);

        return response([
            'record' => $created_post
        ]);
    }

    public function storeV2(Request $request, LinkPreviewService $previewer)
    {
        $validator = \Validator::make($request->all(), [
            'app_token'    => 'required',
            'type'         => 'required|in:article,image,link',
            'isLinkType'   => 'sometimes|boolean',
            'link'         => 'required|url', // image, docs, url links
            'content'      => 'required_unless:isLinkType,1|nullable|string',
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

        $isPostLinkType = isset($request->isLinkType) && $request->isLinkType;
        $scrabingcontent = null;

        if ($isPostLinkType && $request->filled('link')) {
            $preview = $previewer->fetch($request->link);      // title/desc/image/player/…
            $rawHtml = LinkPreviewRenderer::render($preview, $request->link);
            $scrabingcontent = Purifier::clean($rawHtml, 'link_preview');
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

    public function store(Request $request, LinkPreviewService $previewer)
    {
        $validator = \Validator::make($request->all(), [
            'app_token' => 'required',
            'content'   => 'required',
            'link'      => 'required|url',
            'type'      => 'required|in:article,image,link', // keep your allowed values
            'interest'  => 'sometimes|array',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 400);
        }

        $userToken = UserToken::where('token', $request->input('app_token'))->first();
        if (!$userToken) {
            return response()->json(['error' => 'Invalid or missing app token.'], 401);
        }
        $user = $userToken->user;

        // Build preview + rendered HTML with iframe (if applicable)
        $preview = $previewer->fetch($request->link);
        $rawHtml = LinkPreviewRenderer::render($preview, $request->link);

        // sanitize to keep only allowed tags/hosts (see step 4)
        try {
            $scrabingcontent = Purifier::clean($rawHtml, 'link_preview');
        } catch (\Throwable $e) {
            // safe fallback if purifier not ready yet
            $allowed = '<div><p><br><span><a><img><iframe><h1><h2><h3><h4><h5><h6>';
            $scrabingcontent = strip_tags($rawHtml, $allowed);
        }

        $created_post = Post::create([
            'user_id'         => $user->id,
            'content'         => $request->content, // caption only
            'type'            => 'article',         // store as article with preview block
            'from_api'        => true,
            'link'            => $request->link,    // original URL
            'scrabingcontent' => $scrabingcontent,  // <-- iframe-inclusive HTML
        ]);

        if ($request->filled('interest')) {
            $created_post->interests()->attach($request->interest);
        }

        Share::create([
            'post_id'  => $created_post->id,
            'user_id'  => $user->id,
            'group_id' => 0,
        ]);

        return response(['record' => $created_post]);
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
}
