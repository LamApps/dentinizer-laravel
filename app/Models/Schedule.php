<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Schedule extends Model
{
    use HasFactory,LogsActivity;
    public $table = 'doctor_schedules';
    protected static $logName = 'Doctor schedule';
    protected static $logAttributes = ['*'];
}
