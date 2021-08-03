<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Appointment extends Model
{
    use HasFactory,LogsActivity;
    public $table = 'appointments';
    //log
    protected static $logName = 'Appointment';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;


    protected $fillable = ['patient_id', 'doctor_id', 'start_time', 'duration', 'comments', 'status'];

    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function userdoctor()
    {
        return $this->belongsTo(User::class,'doctor_id');
    }
}
