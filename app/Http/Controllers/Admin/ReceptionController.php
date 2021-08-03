<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Library\Services\DbHelperTools;

class ReceptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

         $receptions = DB::table('users')
            ->leftJoin('reception_rates', 'users.id', '=', 'reception_rates.reception_id')
            ->select('users.id', 'users.name', 'reception_rates.count_monthly', 'reception_rates.rate')
            ->where('users.user_type', '=', 'reception')
            ->get();
        // dd($name_arr,$appointments_arr, $rate1_arr, $rate2_arr);
        return view('admin.reception', compact('receptions'));
    }
}
