<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Officetime extends Model
{
    use HasFactory,LogsActivity;
    public $table = 'officetimes';

    protected static $logName = 'Office time';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;

    protected $fillable = ['user_id', 'day', 'from', 'to'];
}
