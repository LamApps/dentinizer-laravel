<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoiceitem extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    public $table = 'inv_invoice_payments';

    protected static $logName = 'Invoice item';
    protected static $logAttributes = ['*'];
}
