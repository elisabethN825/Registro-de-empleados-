<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'primerNombre',
        'otrosNombres',
        'primerApellido',
        'segundoApellido',
        'paisEmpleo',
        'tipoIdentificacion',
        'identificacion',
        'correo',
        'fechaIngreso',
        'area',
        'estado',
        'fechaHoraRegistro',
    ];
}
