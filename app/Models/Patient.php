<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Patient extends Model
{
    use HasFactory,LogsActivity;
    public $table = 'patients';

    protected static $logName = 'Patient';
    protected static $logAttributes = ['*'];

    protected $fillable = ['name','ar_name', 'email', 'birthday', 'address', 'phone', 'state', 'nationality','iqama_id','medical_conditions'];    
}
