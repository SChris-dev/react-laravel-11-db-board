<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LoginToken;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:2|max:20|regex:/[a-zA-Z]+$/',
            'last_name' => 'required|min:2|max:20|regex:/[a-zA-Z]+$/',
            'username' => 'required|min:5|max:12|regex:/[a-zA-Z_.]+$/|unique:users,username',
            'password' => 'required|string|min:5|max:12'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid Field.',
            ], 422);
        }

        $userCreate = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => bcrypt($request->password), // for Auth::attempt system
        ]);

        $user = Auth::user();

        $token = bcrypt($user);

        LoginToken::create([
            'user_id' => $userCreate->id,
            'token' => $token,
        ]);
        

        return response()->json([
            'token' => $token,
            'username' => $request->username,
        ], 200);
        
        
    }

    public function login(Request $request)
    {

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
    
            $token = bcrypt($user);

            LoginToken::where('user_id', $user->id)->update([
                'user_id' => $user->id,
                'token' => $token,
            ]);

            return response()->json([
                'token' => $token,
                'username' => $request->username
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid login',
            ], 401);
        }
        
        
    }

    public function logout() {
        $token = Request()->token;
        $checkToken = LoginToken::where('token', $token);

        if ($checkToken) {
            Auth::logout();
            return response()->json([
                'message' => 'Logout success.'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Unauthorized user'
            ], 401);
        }

    }

}
