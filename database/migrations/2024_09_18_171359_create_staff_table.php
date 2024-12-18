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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('email')->unique();
            $table->date('date_card_validity')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('place_birth')->nullable();
            $table->string('profession')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->enum('contract_type', ['CDD', 'CDI', 'TEMPORAIRE'])->nullable();
            $table->string('marital_status')->nullable();
            $table->string('position')->nullable();
            $table->string('author')->nullable();
            $table->integer('num_children')->nullable();
            $table->foreignId('city_id')->constrained('cities')->noActionOnDelete();
            $table->foreignId('country_id')->constrained('countries')->noActionOnDelete();
            $table->string('neighborhood')->nullable();
            $table->string('attachment_file')->nullable();
            $table->tinyInteger('statut')->default(1)->comment("1 - ACTIF (default) et 0 - ANCIEN");
            $table->boolean('open_close')->default(0);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
