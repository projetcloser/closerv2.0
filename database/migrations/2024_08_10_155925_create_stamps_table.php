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
        Schema::create('stamps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->index();
            $table->string('receipt_number');
            $table->tinyInteger('status')->default(1);  // 1: en cours de fabrication, 2: disponible, 3: envoyée, 4: livrée
            $table->foreignId('city_id')->constrained('cities')->noActionOnDelete();
            $table->string('phone')->nullable();
            $table->string('year')->nullable();
            $table->string('author');
            $table->boolean('open_close')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stamps');
    }
};
