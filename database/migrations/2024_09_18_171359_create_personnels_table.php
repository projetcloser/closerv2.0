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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('statut');
            $table->string('lastname');
            $table->string('firstname');
            $table->string('email')->unique();
            $table->date('date_card_validity')->nullable();
            $table->string('phone')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('place_birth')->nullable();
            $table->string('profession')->nullable();
            $table->string('genre')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('position')->nullable();
            $table->integer('num_children')->nullable();
            $table->boolean('open_close')->default(0);
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
