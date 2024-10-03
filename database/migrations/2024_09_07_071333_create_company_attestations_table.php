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
        Schema::create('company_attestations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('member_id');
            $table->string('payment_amount')->default(1000);
            $table->tinyInteger('cash_register_id')->default(1);
            $table->string('year');
            $table->unsignedInteger('company_id');
            $table->string('motif')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_attestations');
    }
};
