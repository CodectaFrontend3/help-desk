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
        Schema::create('hardwares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_RH')->nullable()->constrained('register_hardwares')->nullOnDelete();
            $table->string('type_team');
            $table->integer('serial_number');
            $table->dateTime('buy_date');
            $table->string('plan');
            $table->string('brand');
            $table->string('supplier');
            $table->longText('description');
            $table->string('end_revision');
            $table->string('revision_scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardwares');
    }
};
