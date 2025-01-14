<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;

class PostController extends Controller
{
    public function store (Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'app_token' => 'required|exists:users,app_token',
            'content' => 'required',
            'link' => 'sometimes',
        ]);

        $user = User::select('id')
            ->where('app_token', $request->app_token)->first();

        if ($validator->fails()) { 
            return response([
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $created_post = Post::create([
            'user_id' => $user->id,
            'content' => $request->content,
            'type' => 'feed',
            'pubDate' => $request->pub_date
        ]);

        return response([
            'record' => $created_post
        ]);
    }
}
