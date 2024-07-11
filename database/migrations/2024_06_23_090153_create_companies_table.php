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
            $table->string('social_reason');
            $table->string('author');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('nui');
            $table->enum('type', ['public', 'private']);
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('city_id');
            $table->string('neighborhood')->nullable();
            $table->string('contact_person');
            $table->string('contact_person_phone');
            $table->tinyInteger('status')->default(1);
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
