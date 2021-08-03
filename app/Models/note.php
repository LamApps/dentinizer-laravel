<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class note extends Model
{
    use LogsActivity;
    public $table = 'notes';
    protected static $logName = 'Note';
    protected static $logAttributes = ['*'];
    protected $fillable = ['user_id', 'patient_id', 'note'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
