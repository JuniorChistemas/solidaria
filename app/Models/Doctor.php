<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    /** @use HasFactory<\Database\Factories\DoctorFactory> */
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'start_date',
        'state',

    ];

    protected function casts()
    {
        return [
            'start_date' => 'datetime',
        ];
    }
}
