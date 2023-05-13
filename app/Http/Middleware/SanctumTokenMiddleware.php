<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;

class SanctumTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(!$request->cookie('authToken')){
            return redirect('/login');
        }
        [$id, $user_token] = explode('|', $request->cookie('authToken'), 2);
        $token_data = DB::table('personal_access_tokens')->where('token', hash('sha256', $user_token))->first();

        if(!$token_data){
            abort(401, 'Unauthorized');
        }
        $user_id = $token_data->tokenable_id; 
        $request->merge([
            'user_id'=>$user_id
        ]);
        return $next($request);
    }
}
