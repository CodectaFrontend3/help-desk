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
        Schema::create('area', function (Blueprint $table) {
            $table->id();
            $table->foreignId('microempresa_id')->constrained('microempresa')->onDelete('cascade');
            $table->foreignId('empresa_id')->constrained('empresa')->onDelete('cascade');
            $table->foreignId('sucursal_id')->constrained('sucursal')->onDelete('cascade');
            $table->string('nombre_area');
            $table->string('contacto');
            $table->string('telefono');
            $table->string('correo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area');
    }
};
 