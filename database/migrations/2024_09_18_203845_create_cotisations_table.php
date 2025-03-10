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
            $table->foreignId('cashflow_id')->constrained('cashflows')->noActionOnDelete();
            $table->date('pay_year');
            $table->string('ref_ing_cost');
            $table->foreignId('member_id')->constrained('members')->noActionOnDelete();
            $table->integer('amount')->default(60000);
            $table->integer('pay');
            // $table->foreignId('staff_id')->constrained('staffs')->noActionOnDelete();
            // $table->foreignId('staff_id')->constrained('staffs')->noActionOnDelete();
            $table->tinyInteger('status')->default(1)->comment("1: non payé, 2: initier, 3: payé");
            $table->string('author');
            $table->boolean('open_close')->default(0);
            $table->timestamps();

            // $table->unsignedBigInteger('user_id'); // Clé étrangère vers la table users
            // // Définir la clé étrangère
            // $table->foreign('user_id')
            //       ->references('id')
            //       ->on('users')
            //       ->onDelete('cascade'); // Supprimer les contributions si l'utilisateur est supprimé
        });

        Schema::create('personal_certificates', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('cashflow_id')->constrained('cashflows')->default(1)->noActionOnDelete();
            $table->foreignId('member_id')->constrained('members')->noActionOnDelete();
            $table->string('ref_dem_part');
            $table->integer('amount')->default(0);
            $table->tinyInteger('status')->default(3)->comment("1 - non payé (default), 2 - initier et 3 - payé");
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
        Schema::dropIfExists('cotisations');
    }
};
