<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interest;
use App\Post;
use App\Share;
use App\User;
use App\UserToken;

class PostController extends Controller
{
    public function store (Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'app_token' => 'required',
            'content' => 'required',
            'link' => 'sometimes', // imageLink or doc link
            'type' => 'required|in:article,image',
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
}
