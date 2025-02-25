<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    /** @use HasFactory<\Database\Factories\LaboratoryFactory> */
    use HasFactory;

    /**
     * Atributo asignable en masa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name', // Nombre Laboratorio
    ];

    /**
     * Los atributos tipo nativos.
     *
     * @var array<string, string>
     */
    // protected function casts()
    // {
    //     return [
    //         'created_at' => 'datetime',
    //         'updated_at' => 'datetime',
    //     ];
    // }

        /**
     * Los atributos con conversión de tipo.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}