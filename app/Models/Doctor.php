<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Doctor extends Model
{
    use HasFactory,LogsActivity;
    public $table = 'doctors';

    protected static $logName = 'Doctor';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;
    
    protected $fillable = ['user_id', 'birthday', 'address', 'phone', 'photo', 'target'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function profiles()
    {
        return $this->hasMany(DoctorProfile::class);
    }
}
