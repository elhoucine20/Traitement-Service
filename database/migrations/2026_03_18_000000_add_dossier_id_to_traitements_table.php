<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('traitements', function (Blueprint $table) {
            $table->string('dossier_id')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('traitements', function (Blueprint $table) {
            $table->dropColumn('dossier_id');
        });
    }
};
