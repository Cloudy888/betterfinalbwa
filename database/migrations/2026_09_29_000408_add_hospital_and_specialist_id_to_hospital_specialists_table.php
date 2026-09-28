<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hospital_specialists', function (Blueprint $table) {
            $table->foreignId('hospital_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('specialist_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unique(['hospital_id', 'specialist_id']);
        });
    }

    public function down(): void
    {
        Schema::table('hospital_specialists', function (Blueprint $table) {
            $table->dropForeign(['hospital_id']);
            $table->dropForeign(['specialist_id']);
            $table->dropUnique(['hospital_specialists_hospital_id_specialist_id_unique']);
            $table->dropColumn(['hospital_id', 'specialist_id']);
        });
    }
};