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
            $table->unsignedBigInteger('cashflow_id');
            $table->date('pay_year');
            $table->string('ref_ing_cost');
            $table->unsignedBigInteger('member_id');
            $table->integer('amount');
            $table->integer('pay');
            $table->string('author');
            $table->string('status')->default('OK');
            $table->unsignedBigInteger('personnel_id');
            $table->boolean('open_close')->default(false);
            $table->timestamps();

            // Foreign keys
            $table->foreign('cashflow_id')->references('id')->on('cashflows')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('personnel_id')->references('id')->on('personnels')->onDelete('cascade');
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
