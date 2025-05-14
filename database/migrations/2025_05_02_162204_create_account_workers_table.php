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
        Schema::create('account_workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_machine')->nullable()->constrained('machines')->nullOnDelete()->unique();
            $table->string('username');
            $table->string('area');
            $table->string('emailT');
            $table->string('password');
            $table->string('branch');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_workers');
    }
};
