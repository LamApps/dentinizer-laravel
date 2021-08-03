<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctorpatient extends Model
{
    use HasFactory;
    public $table = 'doctors_patients';
    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function userdoctor()
    {
        return $this->belongsTo(User::class,'doctor_user_id');
    }
}
