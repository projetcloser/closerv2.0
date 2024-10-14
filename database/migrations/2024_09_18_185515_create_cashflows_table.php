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
        Schema::create('cashflows', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->integer('balance');
            $table->foreignId('staff_id')->constrained('staffs')->noActionOnDelete();
            $table->boolean('open_close')->default(0);
            $table->timestamps();
        });

        Schema::create('personal_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashflow_id')->constrained('cashflows')->noActionOnDelete();
            $table->foreignId('member_id')->constrained('members')->noActionOnDelete();
            $table->foreignId('staff_id')->constrained('staffs')->noActionOnDelete();
            $table->string('ref_dem_part');
            $table->integer('amount')->default(0);
            $table->tinyInteger('status')->default(1)->comment("1 - non payé (default), 2 - initier et 3 - payé");
            $table->date('certification_date')->default(now());
            $table->string('object');
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
        Schema::dropIfExists('personal_certificates');
        Schema::dropIfExists('cashflows');

    }
};
