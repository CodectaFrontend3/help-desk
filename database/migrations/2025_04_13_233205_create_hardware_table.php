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
        Schema::create('hardware', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_RH')->nullable()->constrained('registro_hardware')->nullOnDelete();
            $table->string('tipo_equipo');
            $table->integer('num_serie');
            $table->dateTime('fecha_compra');
            $table->string('plan');
            $table->string('marca');
            $table->string('proveedor');
            $table->longText('descripcion');
            $table->string('ult_revision');
            $table->string('rev_programada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware');
    }
};
