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
        Schema::create('member_academic_states', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('member_id');
            $table->string('lastname');
            $table->string('firstname')->nullable();
            $table->string('username');
            $table->string('email');
            $table->string('birthday')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->string('address')->nullable();
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('city_id');
            $table->string('neighborhood')->nullable();
            $table->string('phone')->nullable();
            $table->string('biography')->nullable();
            $table->string('avatar64')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_academic_states');
    }
};
