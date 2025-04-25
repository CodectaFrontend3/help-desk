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
        Schema::create('branch', function (Blueprint $table) {
            $table->id(); // id_sucursales PK
            $table->unsignedBigInteger('company_id'); // id_empresa FK
            $table->string('branch_name'); // nombre_sucursal
            $table->string('manager'); // encargado
            $table->string('phone'); // telefono
            $table->string('email'); // correo
            $table->timestamps();

            // Cambiado de 'companies' a 'company'
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch');
    }
};
