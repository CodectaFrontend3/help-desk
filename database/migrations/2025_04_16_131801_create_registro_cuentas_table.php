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
        Schema::create('registro_cuentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_clienteG')->nullable()->constrained('cliente_g')->nullOnDelete();
            $table->string('correo');
            $table->string('contraseña');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_cuentas');
    }
};
