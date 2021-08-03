<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function account_setting()
    {
        return view('account_setting');
    }

    public function changepassword(Request $request)
    {
        $this->validate($request, 
        [
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $id             = auth()->user()->id;
        $pass           = $request->password;
        $user           = User::findOrFail($id);
        $user->password = Hash::make($pass);
        $user->save();
        return back()->with('success', 'User Data is successfully updated');
    }

    public function notifications($length) {
        $half_year_ago = date("Y-m-d H:i:s",strtotime("-6 month"));
        $one_month_ago = date("Y-m-d H:i:s",strtotime("-30 day"));
        $year_ago = date("Y-m-d H:i:s",strtotime("-1 year"));

        $user_type = Auth::user()->user_type;
        $query = null;
        switch($user_type) {
            case 'admin':
                $query = Notification::where('owner_type', 'Admin');
            break;
            case 'doctor':
                $query = Notification::where('to_id',Auth::user()->id)->where('message_type',11);
            break;
            case 'reception':
                $query = Notification::where(function ($q) {
                    $q->where('message_type',10)
                    ->orWhere('message_type',12);
                });
            break;
            case 'accountant':
                $query = Notification::where('to_id', Auth::user()->id);
            break;
            case 'nurse':
                $query = Notification::where('to_id', Auth::user()->id);
            break;
            default:
                $query = Notification::where('to_id', Auth::user()->id);
        }
        // dd($one_month_ago);
        if($length=='month') $query = $query->whereDate('created_at','>', $one_month_ago);
        else if($length=='half') $query = $query->whereDate('created_at','>', $half_year_ago);
        else $query = $query->whereDate('created_at','>', $year_ago);
        $my_notifications = $query->get();
        // dd($query);
        return view('notifications', compact('my_notifications', 'length'));
    }

    public function read_all($length) {
        $half_year_ago = date("Y-m-d H:i:s",strtotime("-6 month"));
        $one_month_ago = date("Y-m-d H:i:s",strtotime("-30 day"));
        $year_ago = date("Y-m-d H:i:s",strtotime("-1 year"));

        $user_type = Auth::user()->user_type;
        $query = null;
        if($user_type=="admin") $query = Notification::where('owner_type','Admin')->where('is_read',0);
        else if($user_type=="doctor") $query = Notification::where('to_id',Auth::user()->id)->where('message_type',11)->where('is_read',0);
        else if($user_type=="reception") $query = Notification::where(function ($q) {
                    $q->where('message_type',10)
                    ->orWhere('message_type',12);
                })->where(function ($q) {
                   $q->whereNull('read_users')
                   ->orWhere('read_users', 'not like', '%'.Auth::user()->username.'%');
               });
        else Notification::where('to_id', Auth::user()->id)->where('is_read',0);

        if($length=='month') $query->where('created_at','>', $one_month_ago);
        else if($length=='half') $query->where('created_at','>', $half_year_ago);
        else $query->where('created_at','>', $year_ago);
        if($user_type=="reception"){
            $notifics = $query->get();
            foreach($notifics as $row) {
                $current = Notification::find($row->id);
                $old_read = $current->read_users;
                $current->read_users = $old_read.','.Auth::user()->username;
                $current->save();
            }
        }
        else $query->update(['is_read'=>1]);
    }
}
