<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'tests_offer',
        'price',
        'services',  
    ];

    protected $casts = [
        'services' => 'array',  
    ];
}
