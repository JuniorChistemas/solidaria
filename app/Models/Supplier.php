<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;
    protected $table = 'suppliers';
    protected $fillable = [
        'name',
        'ruc',
        'phone',
        'address',
        'state',
    ];

    protected function casts()
    {
        return [
            'start_date' => 'datetime',
        ];
    }
}
