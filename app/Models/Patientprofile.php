<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patientprofile extends Model
{
    use HasFactory;

    public $table = 'patient_notes';

    protected $fillable = ['patient_id', 'doctor_id', 'category_id', 'teeth_id', 'note', 'type', 'invoiced'];
}
