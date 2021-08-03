<?php

namespace App\Console;

use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->command('backup:run')->everyMinute()
            ->onFailure(function () {
                Log::info('Error backup');
            })
            ->onSuccess(function () {
                Log::info('Success backup');
        });
        $schedule->call(function () {
            // get nitification info
            $half_year_ago = date("Y-m-d H:i:s",strtotime("-6 month"));
            $one_month_ago = date("Y-m-d H:i:s",strtotime("-30 day"));
            $fetch_data = DB::table('appointments')->select('appointments.appuser_id', 'appointments.patient_id', 'appointments.created_at', 'users.name')->leftJoin('users','users.id','=','appointments.appuser_id')->where('users.user_type','reception')->get();
            $before_data = array();
            $after_data = array();
            $month_counts = array();
            $name_array = array();
            foreach($fetch_data as $row) {
                $name_array[$row->appuser_id] = $row->name;

                if(strtotime($row->created_at) > strtotime($one_month_ago)) {
                    if(isset($month_counts[$row->appuser_id])) {
                        $month_counts[$row->appuser_id]++;
                    }else{
                        $month_counts[$row->appuser_id] = 1;
                    }
                }
                if(strtotime($row->created_at) < strtotime($half_year_ago)) {
                    if(isset($before_data[$row->appuser_id])){
                        if(!in_array($row->patient_id, $before_data[$row->appuser_id])) array_push($before_data[$row->appuser_id], $row->patient_id);
                    }else{
                        $before_data[$row->appuser_id] = [$row->patient_id];
                    }
                }else{
                    if(isset($after_data[$row->appuser_id])){
                        if(!in_array($row->patient_id, $after_data[$row->appuser_id])) array_push($after_data[$row->appuser_id], $row->patient_id);
                    }else{
                        $after_data[$row->appuser_id] = [$row->patient_id];
                    }
                }
            }
            // dd($before_data, $after_data);
            foreach($before_data as $key=>$val) {
                foreach($val as $pat1) {
                    if(!in_array($pat1, isset($after_data[$key])?$after_data[$key]:[])) {
                        //finding no or waiting answers
                        $no_or_waitings = DB::table('reception_answers')->where('reception_id',$key)->where('patient_id',$pat1)->where('created_at','>',$half_year_ago)->where('answer','!=',1)->count();
                        if($no_or_waitings==0) DB::table('reception_answers')->insert(
                            [ 'reception_id' => $key, 'patient_id' => $pat1, 'created_at'=>now()]
                        );
                    }
                }
            }
            $yes_answers = array();
            $no_answers = array();
            $votes = DB::table('reception_answers')->get();
            foreach($votes as $row) {
                if(isset($yes_answers[$row->reception_id]))
                    if($row->answer == 1) $yes_answers[$row->reception_id]++;
                else
                    $yes_answers[$row->reception_id] = $row->answer==1?1:0;
                if(isset($no_answers[$row->reception_id]))
                    if($row->answer == 2) $no_answers[$row->reception_id]++;
                else
                    $no_answers[$row->reception_id] = $row->answer==2?1:0;
            }
            $admin_data = DB::table('users')->select('id')->where('user_type','admin')->first();

            foreach($fetch_data as $row) {
                $yes_count = isset($yes_answers[$row->appuser_id])?$yes_answers[$row->appuser_id]:0;
                $no_count = isset($no_count[$row->appuser_id])?$no_count[$row->appuser_id]:0;
                if($yes_count > 0 || $no_count > 0) $rate = round($yes_count  * 100 / ($yes_count + $no_count),2);
                else $rate = 100;
                if($rate<=30) {
                    DB::table('notifications')->updateOrInsert(
                        ['owner_id' => $row->appuser_id, 'owner_type'=>'Admin', 'to_id'=>$admin_data->id, 'is_read'=>0, 'message_type'=>0],
                        ['notification' => 'The reception '.$name_array[$row->appuser_id].'\'s rate is '.$rate.'%', 'created_at'=>date("Y-m-d H:i:s")]
                    );
                }
                DB::table('reception_rates')
                    ->updateOrInsert(
                        ['reception_id' => $row->appuser_id],
                        ['count_monthly'=>isset($month_counts[$row->appuser_id])?$month_counts[$row->appuser_id]:0,'rate' => $rate]
                    );
            }
        })->daily()->onFailure(function () {
                Log::info('Error Calculation');
            })
            ->onSuccess(function () {
                Log::info('Success Calculation');
            });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
