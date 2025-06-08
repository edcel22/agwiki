<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{
    User,
    UserToken
};

class UsersController extends Controller
{
    public function login(Request $request)
    {
        // return 'try';
        $user = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($user)) {
            $token = uniqid();
            $user = User::where('email', $request->email)->first();
            $user->update([
                'app_token' => $token
            ]);

            UserToken::create([
                'user_id'=> $user->id,
                'token'=> $token
            ]);

            return response([
                'user_id' => $user->id,
                'token' => $token,
                'username' => $user->username,
                'name' => $user->name,
            ]);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }
}
