<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSocialsManagementController extends Controller
{
    public function ViewMySocials(Request $request, $id)
    {

        return view('user-socials', compact('id'));
    }

    public function PostMySocials(Request $request)
    {
        $user_id = $request->user_id;

        $bulk_insert = $request->value;


        foreach ($bulk_insert as $key => $value) {
            $bulk_insert[$key]['user_id'] = $user_id;
        }

        $profile = $request->profile;

        DB::table('users_profile')->updateOrInsert(
            ['user_id'=>$user_id],
            [
                'bio'=> $profile['bio'],
                'pronounce'=>$profile['pronounce'],
                'nationality'=>$profile['nationality'],
                'color'=>$profile['color']
            ]
        );

        DB::table('users_socials')->where('user_id', $user_id)->delete();


        DB::table('users_socials')->insert($bulk_insert);
    }

    public function CreateMySocials(Request $request)
    {
        $socials = DB::table('socials_type')->get();

        return view('user-socials', compact('socials'));
    }

    public function ViewUserSocials(Request $request,$id)
    {
        $user_id = 0;
        $whom_id = $id;
        $data = DB::table('users_socials')->where('user_id', $id)->get();
        $user_data = DB::table('users')->where('id', $id)->select('email', 'name')->first();
        $user_profile = DB::table('users_profile')->where('user_id', $id)->first();
        // dd($user_profile);

        return view('home', compact('data', 'user_id', 'user_data', 'whom_id', 'user_profile'));
    }
}
