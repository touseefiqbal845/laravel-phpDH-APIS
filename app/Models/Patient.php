<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'gender',
        'location',
        'contact_info',
        'status',
    ];

    protected $casts = [
        'contact_info' => 'array', 
    ];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_patient');
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
    public function appointments()
{
    return $this->hasMany(Appointment::class);
}

}
