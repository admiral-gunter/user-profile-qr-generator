<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        if($request->cookie('authToken')){
            [$id, $user_token] = explode('|', $request->cookie('authToken'), 2);
            $token_data = DB::table('personal_access_tokens')->where('token', hash('sha256', $user_token))->first();

            if($token_data) return redirect('/home');
        }

        return view('auth.login');
    }
}
