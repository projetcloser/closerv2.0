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
        Schema::create('cotisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashflow_id')->constrained('cashflows')->noActionOnDelete();;
            $table->date('pay_year');
            $table->string('ref_ing_cost');
            $table->foreignId('member_id')->constrained('members')->noActionOnDelete();
            $table->integer('amount')->default(60000);
            $table->integer('pay');
            $table->foreignId('staff_id')->constrained('staffs')->noActionOnDelete();
            $table->string('status')->default('OK');
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
        Schema::dropIfExists('cotisations');
    }
};
