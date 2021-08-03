<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoicerefund extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    public $table = 'inv_invoice_refunds';
    protected static $logName = 'Invoice refund';
    protected static $logAttributes = ['*'];
}
