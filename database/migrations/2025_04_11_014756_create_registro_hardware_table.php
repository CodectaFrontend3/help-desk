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
        Schema::create('registro_hardware', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_instalacion');
            $table->longText('descripcion');
            $table->string('serie');
            $table->string('proveedor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_hardware');
    }
};
