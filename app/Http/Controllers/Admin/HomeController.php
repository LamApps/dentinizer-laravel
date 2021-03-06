<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Services\DbHelperTools;

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
        $patients = Patient::all();
        $doctors = User::all()->where('user_type', 'doctor');
        $services = Service::all();
        $appointments = Appointment::all();
        $users = User::all();
        $services=Service::all();

        // $admin_notifications = Notification::where('to_id', Auth::user()->id)->where('is_read',0)->get();
        // View::share('admin_notifications', $admin_notifications);
        return view('dashboard.admin',compact('appointments', 'patients', 'doctors','users','services'));
    }
    public function sdtDoctorStats(Request $request)
    {
        $DbHelperTools=new DbHelperTools();
        $data=$meta=[];
        $doctors = Doctor::join('users', 'doctors.user_id', '=', 'users.id')->get(['doctors.*', 'users.name', 'users.email']);

        $start=$end=null;
        if ($request->isMethod('post')) {
                if ($request->has('filter_range')) {
                    $tab=explode('to',$request->filter_range);
                    if(count($tab)>0){
                        if(!empty($tab[0]) && !empty($tab[1])){
                            $start = trim($tab[0]);
                            $end = trim($tab[1]);
                        }
                    }
                }
                if ($request->has('quick_type')) {
                    $quick_type=$request->quick_type;
                    if($quick_type=='today'){
                        $dtNow=Carbon::now();
                        $start=$dtNow->format('Y-m-d');
                        $end=$dtNow->format('Y-m-d');
                    }
                    if($quick_type=='yesterday'){
                        $yesterday = Carbon::yesterday();
                        $start=$yesterday->format('Y-m-d');
                        $end=$yesterday->format('Y-m-d');
                    }
                    if($quick_type=='this_month'){
                        $this_month = new Carbon('first day of this month');
                        $start=$this_month->format('Y-m-d');
                        $dtNow=Carbon::now();
                        $end=$dtNow->format('Y-m-d');
                    }
                    if($quick_type=='this_year'){
                        $dtNowA=Carbon::now();
                        $startOfYear = $dtNowA->copy()->startOfYear();
                        $start=$startOfYear->format('Y-m-d');
                        $dtNow=Carbon::now();
                        $end=$dtNow->format('Y-m-d');
                    }
                    if($quick_type=='last_7_days'){
                        $date = Carbon::today()->subDays(7);
                        $start=$date->format('Y-m-d');
                        $dtNow=Carbon::now();
                        $end=$dtNow->format('Y-m-d');
                        //dd($start);
                    }
                    if($quick_type=='last_30_days'){
                        $date = Carbon::today()->subDays(30);
                        $start=$date->format('Y-m-d');
                        $dtNow=Carbon::now();
                        $end=$dtNow->format('Y-m-d');
                        //dd($start);
                    }
                    if($quick_type=='last_month'){
                        $start_last_month = new Carbon('first day of last month');
                        $end_last_month = new Carbon('last day of last month');
                        $start=$start_last_month->format('Y-m-d');
                        $end=$end_last_month->format('Y-m-d');
                        //dd($end);
                    }
                    if($quick_type=='reset'){
                        $start=$end=null;
                    }
                }
        }
        foreach ($doctors as $d) {
            $stats=$DbHelperTools->getStatsByDoctors($d->user_id,$start,$end);
            $row=array();
            //th>Doctor</th>
            $row[]='<div class="d-flex align-items-center"><div><div class="font-weight-bolder">'.$d->name.'</div><div class="font-small-2 text-muted">'.$d->email.'</div></div></div>';
            //<th>Income</th>
            $row[]='<span class="badge badge-light-success">'.number_format($stats['incomes'],2).' '.env('CURRENCY_SYMBOL').'</span>';
            //<th>Refund</th>
            $row[]='<span class="badge badge-light-danger">'.number_format($stats['refunds'],2).' '.env('CURRENCY_SYMBOL').'</span>';
            $data[]=$row;
        }    
        $result = [
            'data' => $data,
        ];
        return response()->json($result);
    }
    public function dashboardStats(Request $request){
        $DbHelperTools=new DbHelperTools();
        $start=$end=null;
        if ($request->isMethod('post')) {
            if ($request->has('filter_range')) {
                $tab=explode('to',$request->filter_range);
                if(count($tab)>0){
                    if(!empty($tab[0]) && !empty($tab[1])){
                        $start = trim($tab[0]);
                        $end = trim($tab[1]);
                    }
                }
            }
            if ($request->has('quick_type')) {
                $quick_type=$request->quick_type;
                if($quick_type=='today'){
                    $dtNow=Carbon::now();
                    $start=$dtNow->format('Y-m-d');
                    $end=$dtNow->format('Y-m-d');
                }
                if($quick_type=='yesterday'){
                    $yesterday = Carbon::yesterday();
                    $start=$yesterday->format('Y-m-d');
                    $end=$yesterday->format('Y-m-d');
                }
                if($quick_type=='this_month'){
                    $this_month = new Carbon('first day of this month');
                    $start=$this_month->format('Y-m-d');
                    $dtNow=Carbon::now();
                    $end=$dtNow->format('Y-m-d');
                }
                if($quick_type=='this_year'){
                    $dtNowA=Carbon::now();
                    $startOfYear = $dtNowA->copy()->startOfYear();
                    $start=$startOfYear->format('Y-m-d');
                    $dtNow=Carbon::now();
                    $end=$dtNow->format('Y-m-d');
                }
                if($quick_type=='last_7_days'){
                    $date = Carbon::today()->subDays(7);
                    $start=$date->format('Y-m-d');
                    $dtNow=Carbon::now();
                    $end=$dtNow->format('Y-m-d');
                    //dd($start);
                }
                if($quick_type=='last_30_days'){
                    $date = Carbon::today()->subDays(30);
                    $start=$date->format('Y-m-d');
                    $dtNow=Carbon::now();
                    $end=$dtNow->format('Y-m-d');
                    //dd($start);
                }
                if($quick_type=='last_month'){
                    $start_last_month = new Carbon('first day of last month');
                    $end_last_month = new Carbon('last day of last month');
                    $start=$start_last_month->format('Y-m-d');
                    $end=$end_last_month->format('Y-m-d');
                    //dd($end);
                }
                if($quick_type=='reset'){
                    $start=$end=null;
                }
            }
        }
        $results=$DbHelperTools->getDashboardStats($start,$end);
        return response()->json($results);
    }

    public function viewNotification($id) {
        $notification = Notification::find($id);
        $notification->is_read = 1;
        $notification->save();

        return redirect('admin/reception');
    }
}
