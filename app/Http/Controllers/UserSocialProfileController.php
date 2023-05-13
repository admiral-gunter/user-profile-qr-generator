<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSocialProfileController extends Controller
{
    public function home(Request $request)
    {
        $user_id = $request->user_id;
        $whom_id = $user_id;
        $data = DB::table('users_socials')->where('user_id', $user_id)->get();
        $user_data = DB::table('users')->where('id', $user_id)->select('email', 'name')->first();
        // dd($user_data);
        return view('home', compact('data', 'user_id', 'user_data', 'whom_id'));
    }
}
