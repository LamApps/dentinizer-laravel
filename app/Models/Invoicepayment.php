<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoicepayment extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    public $table = 'inv_invoice_payments';
    protected static $logName = 'Invoice payment';
    protected static $logAttributes = ['*'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class,'invoice_id');
    }
}
