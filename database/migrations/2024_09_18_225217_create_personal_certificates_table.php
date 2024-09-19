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
        Schema::create('personal_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashflow_id')->constrained('cashflows')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('personnel_id')->constrained('personnels')->onDelete('cascade');
            $table->string('ref_dem_part');
            $table->integer('amount')->default(0);
            $table->string('status')->default('envoyer');
            $table->date('date_certification')->default(now());
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
    }
};
