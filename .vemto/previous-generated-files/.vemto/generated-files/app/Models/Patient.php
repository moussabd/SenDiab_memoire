<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'patient';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctorPatients()
    {
        return $this->hasOne(DoctorPatient::class, 'patient_id');
    }

    public function monitorings()
    {
        return $this->hasMany(Monitoring::class);
    }
}
