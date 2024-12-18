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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            // remplacer company_name par social_reason
            $table->string('social_reason');
            $table->enum('company_type', ['PUBLIC', 'PRIVEE']);
            $table->string('email')->nullable();
            $table->string('nui');
            $table->foreignId('country_id')->constrained('countries')->noActionOnDelete();
            $table->foreignId('city_id')->constrained('cities')->noActionOnDelete();
            $table->string('phone');
            $table->string('neighborhood')->nullable();
            $table->string('contact_person');
            $table->string('contact_person_phone');
            $table->string('author')->nullable();
            $table->boolean('open_close')->default(0);      
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
