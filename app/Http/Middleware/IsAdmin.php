<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() &&  Auth::user()->user_type  == "admin" ) {

            $admin_notifications = DB::table('notifications')->where('to_id', Auth::user()->id)->where('is_read',0)->get();
            view()->share('admin_notifications', $admin_notifications);

            return $next($request);
        }
        //abort(403);
       return redirect('home')->with('error','You have not admin access');
    }
}
