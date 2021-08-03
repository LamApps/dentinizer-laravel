<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Library\Services\DbHelperTools;

class ApiController extends Controller
{
    public function reportsStats($start,$end,$doctor_id){
        $DbHelperTools=new DbHelperTools();
        $results=$DbHelperTools->getReportStats($doctor_id,$start,$end);
        return response()->json($results);
    }
    public function getJsonFinancesApexChart($type_data,$start,$end,$doctor_id){
        //$doctor_id=0;
        $DbHelperTools=new DbHelperTools();
        $periods = CarbonPeriod::create($start, $end);
        // Iterate over the period
        $production_datas=$collection_datas=[];
        foreach ($periods as $date) {
            $calcul=$DbHelperTools->getStatsForReports($doctor_id,$date->format('Y-m-d'),$date->format('Y-m-d'));
            if($type_data==0 || $type_data==1){
                $p_row=array();
                $p_row['x']=$date->format('m/d');
                $p_row['y']=$calcul['total_amount_invoices'];
                $production_datas[]=$p_row;
            }
            //
            if($type_data==0 || $type_data==2){
                $c_row=array();
                $c_row['x']=$date->format('m/d');
                $c_row['y']=$calcul['total_amount_payed_invoices'];
                $collection_datas[]=$c_row;
            }
        }
        //global stats
        $calcul=$DbHelperTools->getStatsForReports($doctor_id,$start, $end);
        $stats=[
            'production'=>number_format($calcul['total_amount_invoices'],2).' '.env('CURRENCY_SYMBOL'),
            'collection'=>number_format($calcul['total_amount_payed_invoices'],2).' '.env('CURRENCY_SYMBOL'),
            'discounts'=>number_format($calcul['total_amount_discount'],2).' '.env('CURRENCY_SYMBOL'),
            'taxes'=>number_format($calcul['total_tax_amount'],2).' '.env('CURRENCY_SYMBOL'),
        ];
        return response ()->json ([ 
            'production' => $production_datas,
            'collection' => $collection_datas,
            'stats' => $stats,
        ]);
    }
    public function getJsonAppointmentsApexChart($type_data,$start,$end,$doctor_id){
        /* 
        $type_data==0 ==> all datas
        $type_data==1 ==> show only booked
        $type_data==2 ==> show only confirmed
        $type_data==3 ==> show only canceled
        $type_data==4 ==> show only attended
        */
        $DbHelperTools=new DbHelperTools();
        //dd($request->all());
        //$doctor_id=0;
        $periods = CarbonPeriod::create($start, $end);
        // Iterate over the period
        $booked_datas=$confirmed_datas=$canceled_datas=$attended_datas=[];
        foreach ($periods as $date) {
            $calcul=$DbHelperTools->getAppointmentsStatsForReports($doctor_id,$date->format('Y-m-d'),$date->format('Y-m-d'));
            //booked
            if($type_data==0 || $type_data==1){
                $p_row=array();
                $p_row['x']=$date->format('m/d');
                $p_row['y']=$calcul['nb_booked'];
                $booked_datas[]=$p_row;
            }
            //confirmed
            if($type_data==0 || $type_data==2){
                $c_row=array();
                $c_row['x']=$date->format('m/d');
                $c_row['y']=$calcul['nb_confirmed'];
                $confirmed_datas[]=$c_row;
            }
            //canceled
            if($type_data==0 || $type_data==3){
                $c_row=array();
                $c_row['x']=$date->format('m/d');
                $c_row['y']=$calcul['nb_canceled'];
                $canceled_datas[]=$c_row;
            }
            //attended
            if($type_data==0 || $type_data==4){
                $c_row=array();
                $c_row['x']=$date->format('m/d');
                $c_row['y']=$calcul['nb_attended'];
                $attended_datas[]=$c_row;
            }
        }
        //global stats
        $calcul=$DbHelperTools->getAppointmentsStatsForReports($doctor_id,$start,$end);
        $sum=$calcul['nb_booked']+$calcul['nb_confirmed']+$calcul['nb_canceled']+$calcul['nb_attended'];
        $percent=0;
        if($sum>0){
            $percent=($calcul['nb_canceled']/$sum)*100;
        }
        $stats=[
            'nb_booked'=>$calcul['nb_booked'],
            'nb_confirmed'=>$calcul['nb_confirmed'],
            'nb_canceled'=>$calcul['nb_canceled'],
            'percent_canceled'=>number_format($percent,2),
            'nb_attended'=>$calcul['nb_attended'],
        ];
        return response ()->json ([ 
            'booked' => $booked_datas,
            'confirmed' => $confirmed_datas,
            'canceled' => $canceled_datas,
            'attended' => $attended_datas,
            'stats' => $stats,
        ]);
    }
    public function selectDoctorsOptions(){
        $result=[];
        $rows=Doctor::all(); 
        if(count($rows)>0){
            foreach($rows as $row){
                $result[]=['id'=>$row['user_id'],'name'=>$row->user->name];
            }
        }
        return response()->json($result);
    }
}
