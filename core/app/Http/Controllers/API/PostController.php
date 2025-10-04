<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interest;
use App\Post;
use App\Services\LinkPreviewService;
use App\Share;
use App\User;
use App\UserToken;

class PostController extends Controller
{
    public function storeV1 (Request $request)
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

    public function store (Request $request, LinkPreviewService $previewer)
    {
        $validator = \Validator::make($request->all(), [
            'app_token' => 'required',
            'content'   => 'required',
            'link'      => 'required|url', // image, pdf, url
            'type'      => 'required|in:article,image,link',
            'interest'  => 'sometimes|array',
            'isLinkType'    => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $userToken = UserToken::where('token', $request->input('app_token'))->first();
        if (!$userToken) {
            return response()->json(['error' => 'Invalid or missing app token.'], 401);
        }
        $user = $userToken->user;

        $preview = null;
        $isPostLinkType = isset($request->isLinkType) && $request->isLinkType;
        if ($isPostLinkType) {
            $preview = $previewer->fetch($request->link);
            // Optional: if crawling fails, you can still proceed or bail out:
            // if (!$preview['ok']) { return response()->json(['error' => 'Link preview failed'], 422); }
        }

        $created_post = Post::create([
            'user_id'      => $user->id,
            'content'      => $request->content,
            'type'         => $request->type,
            'from_api'     => true,
            'link'         =>  $isPostLinkType ? '' : $request->link,
            'link_preview' => $preview,   // requires JSON column & cast
        ]);

        if ($request->filled('interest')) {
            $created_post->interests()->attach($request->interest);
        }

        $share = Share::create([
            'post_id' => $created_post->id,
            'user_id' => $user->id,
            'group_id' => 0,
        ]);

        return response([
            'record' => $created_post
        ]);
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

    public function destroy (Request $request, Post $post) {
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
