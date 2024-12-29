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
        Schema::create('payment_payloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->noActionOnDelete();
            $table->bigInteger('company_attestation_id')->nullable();
            $table->bigInteger('cotisation_id')->nullable();
            $table->string('transaction_id');
            $table->longText('request_result');
            $table->longText('form_data');
            $table->longText('check_result')->nullable();
            $table->string('status')->default("CREATED");
            $table->boolean('open_close')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_payloads');
    }
};
