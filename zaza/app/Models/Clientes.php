<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
            'Nombre',
            'apellido',
            'phone',
            'direccion',
            'email',
            'contraseña',
    ];
}
