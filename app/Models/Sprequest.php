<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sprequest extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    public $table = 'sp_requests';
    //log
    protected static $logName = 'Request';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
