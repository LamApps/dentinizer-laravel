<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Patientstorage extends Model
{
    use HasFactory,LogsActivity;
    public $table = 'patient_storage';
     //log
     protected static $logName = 'Storage';
     protected static $logAttributes = ['*'];
     protected static $logOnlyDirty = false;

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
