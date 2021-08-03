<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\User;
use App\Models\Officetime;

class OfficetimeController extends Controller
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
        //$doctors = User::all()->where('user_type', 'doctor')->where('state', 1);

        $doctors =Doctor::all();

        $current_time = $date = date('y-m-d h:i:s');

        /* $officetimes = DB::table('officetimes')
            ->leftJoin('users', 'users.id', '=', 'officetimes.user_id')
            ->select('officetimes.id', 'users.name', 'users.email', 'officetimes.day', 'officetimes.from', 'officetimes.to', 'officetimes.user_id')
            ->orderBy('officetimes.day', 'DESC')
            ->get(); */
        $officetimes= DB::table('officetimes')->join('users', 'users.id', '=', 'officetimes.user_id')
        ->select('officetimes.*', 'users.name')
        ->orderBy('officetimes.day', 'DESC')->get();

        return view('admin.officetime', compact('doctors', 'officetimes', 'current_time'));
    }

    public function store(Request $data) 
    {
        
        Officetime::updateOrCreate(
            [
                'id' => $data['id']
            ],
            [
            'user_id' => $data['user_id'],
            'day' => $data['day'],
            'from' => $data['from'],
            'to' => $data['to'],
        ]);

        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function destroy($id)
    {
            $officetime = Officetime::findOrFail($id);
            $officetime->delete();

            return redirect('/admin/officetime')->with('success', 'Appointment Data is successfully deleted');
    }

}
