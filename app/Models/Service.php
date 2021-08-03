<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Service extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    public $table = 'services';

    //log
    protected static $logName = 'Service';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;

    protected $fillable = ['service_name', 'price', 'note', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
