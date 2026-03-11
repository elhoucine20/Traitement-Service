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
        //
            Schema::create('medicament_traitement', function (Blueprint $table) {
            $table->id();
            $table->integer('dosage');
            $table->integer('duration');
            $table->string('region');
            $table->foreignId('traitement_id');
            $table->foreignId('medicament_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('medicament_traitement');

    }
};
