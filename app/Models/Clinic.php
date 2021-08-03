<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Clinic extends Model
{
    use HasFactory,LogsActivity;
    public $table = 'clinics';

    protected static $logName = 'Clinic';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;

    protected $fillable = ['year', 'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
}
