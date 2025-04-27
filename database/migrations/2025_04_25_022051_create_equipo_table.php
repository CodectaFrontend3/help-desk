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
        Schema::create('equipo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_clienteG')->nullable()->constrained('cliente_g')->nullOnDelete();
            $table->foreignId('id_empresa')->nullable()->constrained('company')->nullOnDelete();
            $table->foreignId('id_microempresa')->nullable()->constrained('micro_empresas')->nullOnDelete();
            $table->foreignId('id_personaN')->nullable()->constrained('persona_natural')->nullOnDelete();
            $table->foreignId('id_plan')->nullable()->constrained('planes')->nullOnDelete();
            $table->string('tipo');
            $table->string('marca');
            $table->string('nombre_usuario');
            $table->dateTime('ult_revision');
            $table->dateTime('revision_programada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo');
    }
};
