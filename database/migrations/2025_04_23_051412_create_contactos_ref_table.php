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
        Schema::create('contactos_ref', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresa')->onDelete('cascade');
            $table->foreignId('microempresa_id')->constrained('micro_empresas')->onDelete('cascade');
            $table->foreignId('persona_natural_id')->constrained('persona_natural')->onDelete('cascade');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('correo');
            $table->string('telefono');
            $table->string('cargo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos_ref');
    }
};
