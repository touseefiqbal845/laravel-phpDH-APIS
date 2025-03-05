<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SearchableTrait;

class Doctor extends Model
{
    use HasFactory, SearchableTrait;

    protected $fillable = [
        'name',
        'career',
        'experience',
        'speciality',
        'stories',
        'rating',
        'is_favourite',
        'reviews',
        'hour_rate',
        'time_slot',
        'details',
        'is_featured',
    ];

    protected $casts = [
        'stories' => 'array',
        'time_slot' => 'array',
        'details' => 'array',
    ];

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'doctor_patient');
    }

    public function appointments()
{
    return $this->hasMany(Appointment::class);
}



}
