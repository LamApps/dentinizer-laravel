<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Xray extends Model
{
    use HasFactory,LogsActivity;
    public $table = 'xrays';
     //log
     protected static $logName = 'Xray';
     protected static $logAttributes = ['*'];
     protected static $logOnlyDirty = false;

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
