<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoicelist extends Model
{
    use HasFactory;
    public $table = 'invoice_lists';

    protected $fillable = ['invoice_code','invoice_id', 'teeth_id', 'service', 'amount'];
}
