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
        // DB::table('users_social')->updateOrInsert('id', )
    }

    public function CreateMySocials(Request $request)
    {
        $socials = DB::table('socials_type')->get();

        return view('user-socials', compact('socials'));
    }
}
