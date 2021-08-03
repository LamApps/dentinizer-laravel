<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sprequestitem extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    public $table = 'sp_request_items';
    //log
    protected static $logName = 'Request item';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;

    public function sprequest()
    {
        return $this->belongsTo(Sprequest::class,'request_id');
    }
    
}
