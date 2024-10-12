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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('matricule');
            $table->string('lastname');
            $table->string('firstname')->nullable();
            $table->string('email');
            $table->string('order_number');
            $table->string('phone');
            $table->string('phone_2')->nullable();
            $table->string('folder')->nullable();
            $table->string('picture')->nullable();
            $table->string('debt')->default(0);
            $table->tinyInteger('status')->default(1)->comment("1 - actif et 2 - décédé");
            $table->string('author')->nullable();
            $table->boolean('open_close')->default(0);
            $table->timestamps();
        });

        Schema::create('member_academic_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->index();
            $table->string('birth_day')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->string('address')->nullable();
            $table->foreignId('country_id')->constrained('countries')->noActionOnDelete();
            $table->foreignId('city_id')->constrained('cities')->noActionOnDelete();
            $table->string('neighborhood')->nullable();
            $table->string('biography')->nullable();
            $table->string('avatar64')->nullable();
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
        Schema::dropIfExists('members');
        Schema::dropIfExists('member_academic_states');
    }
};
