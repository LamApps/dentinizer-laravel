<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Library\Services\DbHelperTools;


class UserController extends Controller
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
        $users = User::all();
        return view('admin.users',compact('users'));
    }

    

    public function setstate($id, $key)
    {
            $user = User::findOrFail($id);
            $user->state = $key;
            $user->save();
            return redirect('/admin/users')->with('success', 'User Data is successfully updated');
    }

    

    public function resetpass($id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make('12345');
        $user->save();
        return redirect('/admin/users')->with('success', 'User Data is successfully updated');
    }

    public function settype(Request $data)
    {
        $user = User::findOrFail($data['id']);
        $user->user_type = $data['user_type'];
        $user->save();
        $user_id = $user->id;

        //create if type is doctor
        if($data['user_type']=='doctor' && $user_id>0){
            $DbHelperTools=new DbHelperTools();
            $rsDoctor=Doctor::select('id')->where('user_id',$user_id)->first();
            if(!$rsDoctor){
                $data = array(
                    'id'=>0,
                    'target'=>0,
                    'user_id'=>$user_id,
                );
                //dd($data);
                $doctor_id=$DbHelperTools->manageDoctor($data);
            }
        }

        return response()->json(['success'=>'Ajax request submitted successfully']);
    }
    

    public function destroy($id)
    {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect('/admin/users')->with('success', 'User Data is successfully deleted');
    }


}
