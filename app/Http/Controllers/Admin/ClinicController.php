<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clinic;


class ClinicController extends Controller
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
        $clinics = Clinic::all();
        return view('admin.clinic', compact('clinics'));
    }

    public function store(Request $data) 
    {
        Clinic::create([
            'year' => $data['a_year'],
            'jan' => $data['a_jan'],
            'feb' => $data['a_feb'],
            'mar' => $data['a_mar'],
            'apr' => $data['a_apr'],
            'may' => $data['a_may'],
            'jun' => $data['a_jun'],
            'jul' => $data['a_jul'],
            'aug' => $data['a_aug'],
            'sep' => $data['a_sep'],
            'oct' => $data['a_oct'],
            'nov' => $data['a_nov'],
            'dec' => $data['a_dec']
        ]);

        return redirect('/admin/clinic');
        
    }


    public function update(Request $data) 
    {
        Clinic::updateOrCreate(
            [
                'id' => $data['e_clinic_id']
            ],
            [
            'year' => $data['e_year'],
            'jan' => $data['e_jan'],
            'feb' => $data['e_feb'],
            'mar' => $data['e_mar'],
            'apr' => $data['e_apr'],
            'may' => $data['e_may'],
            'jun' => $data['e_jun'],
            'jul' => $data['e_jul'],
            'aug' => $data['e_aug'],
            'sep' => $data['e_sep'],
            'oct' => $data['e_oct'],
            'nov' => $data['e_nov'],
            'dec' => $data['e_dec']
        ]);

        return redirect('/admin/clinic');
        
    }


    public function destroy($id)
    {
        $clinic = Clinic::findOrFail($id);
        $clinic->delete();
        return redirect('/admin/clinic')->with('success', 'Appointment Data is successfully deleted');
    }


}
