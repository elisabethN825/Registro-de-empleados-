<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('primerNombre', 20);
            $table->string('otrosNombres', 50)->nullable();
            $table->string('primerApellido', 20);
            $table->string('segundoApellido', 20)->nullable();
            $table->string('paisEmpleo');
            $table->string('tipoIdentificacion', 5);
            $table->string('identificacion', 20)->unique();
            $table->string('correo', 300)->unique();
            $table->date('fechaIngreso');
            $table->string('area');
            $table->string('estado')->default('Activo');
            $table->string('fechaHoraRegistro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
