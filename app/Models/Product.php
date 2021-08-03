<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    public $table = 'sp_products';
    //log
    protected static $logName = 'Product';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;
}
