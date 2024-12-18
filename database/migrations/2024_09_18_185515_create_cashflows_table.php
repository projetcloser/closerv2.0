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
        
                Schema::create('company_attestations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->index();
            $table->string('payment_amount')->default(1000);
            $table->string('ref_dem_part')->nullable();
            $table->foreignId('cashflow_id')->constrained('cashflows')->default(1)->noActionOnDelete();
            $table->string('year');
            $table->foreignId('company_id')->index();
            $table->string('motif')->nullable();
            $table->tinyInteger('status')->default(1)->comment("1: non payé, 2: initier, 3: payé");
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
        Schema::dropIfExists('cashflows');
        
        Schema::dropIfExists('company_attestations');

    }
};
