<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    public $table = 'service_categories';

    //log
    protected static $logName = 'Service category';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;

    protected $fillable = ['parent_id', 'name'];

    public function services()
    {
        return $this->hasMany(Service::class,'category_id');
    }
}
