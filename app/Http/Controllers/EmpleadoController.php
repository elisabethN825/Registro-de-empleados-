<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpleadoController extends Controller
{
    public function store(Request $request)
    {
        // Validar datos
        $validator = Validator::make($request->all(), [
            'primerNombre' => 'required|string|max:20',
            'otrosNombres' => 'nullable|string|max:50',
            'primerApellido' => 'required|string|max:20',
            'segundoApellido' => 'nullable|string|max:20',
            'paisEmpleo' => 'required|in:Colombia,Estados Unidos',
            'tipoIdentificacion' => 'required|in:CC,CE,PA,PEP',
            'identificacion' => 'required|string|max:20|unique:empleados,identificacion',
            'correo' => 'required|email|max:300|unique:empleados,correo',
            'fechaIngreso' => 'required|date',
            'area' => 'required|string',
            'estado' => 'required|string',
            'fechaHoraRegistro' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Guardar empleado
        $empleado = Empleado::create($request->all());

        return response()->json([
            'mensaje' => 'Empleado registrado correctamente',
            'empleado' => $empleado
        ]);
    }
}

