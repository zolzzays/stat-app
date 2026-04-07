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
        Schema::table('plant_output', function (Blueprint $table) {
            $table->smallInteger('year')->after('power_plant_id');
            $table->tinyInteger('month')->after('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plant_output', function (Blueprint $table) {
            $table->dropColumn(['year', 'month']);
        });
    }
};
