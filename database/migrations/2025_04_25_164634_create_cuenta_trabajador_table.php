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
        Schema::create('cuenta_trabajador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_equipos')->nullable()->constrained('equipo')->nullOnDelete()->unique();
            $table->string('nombre_usuario');
            $table->string('area');
            $table->string('correoT');
            $table->string('contraseña');
            $table->string('sucursal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuenta_trabajador');
    }
};
