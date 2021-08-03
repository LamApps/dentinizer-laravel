<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Storage extends Model
{
    use HasFactory,LogsActivity;
    public $table = 'patient_storage';
    //log
    protected static $logName = 'Storage';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;

    protected $fillable = ['patient_id', 'title', 'description', 'url'];
}
