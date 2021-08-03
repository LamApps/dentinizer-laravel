<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Nurse extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;

    //log
    protected static $logName = 'Nurse';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;
}
