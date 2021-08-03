<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoice extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    public $table = 'inv_invoices';

    protected static $logName = 'Invoice';
    protected static $logAttributes = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class,'doctor_id');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }
}
