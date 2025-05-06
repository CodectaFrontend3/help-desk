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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_clientG')->nullable()->constrained('clients_g')->nullOnDelete();
            $table->foreignId('id_company')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignId('id_microcompany')->nullable()->constrained('micro_companies')->nullOnDelete();
            $table->foreignId('id_personN')->nullable()->constrained('natural_persons')->nullOnDelete();
            $table->foreignId('id_plan')->nullable()->constrained('plans')->nullOnDelete();
            $table->string('type');
            $table->string('brand');
            $table->string('username');
            $table->dateTime('end_revision');
            $table->dateTime('revision_scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
