<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Procedureserviceitem extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    public $table = 'pr_procedure_service_items';

    protected static $logName = 'Procedure service';
    protected static $logAttributes = ['*'];
    
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class,'invoice_id');
    }
    public function doctor()
    {
        return $this->belongsTo(User::class,'doctor_id');
    }
}
