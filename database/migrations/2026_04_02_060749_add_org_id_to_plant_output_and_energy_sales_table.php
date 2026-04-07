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
            $table->foreignId('org_id')->nullable()->constrained('organizations')->nullOnDelete()->after('power_plant_id');
        });

        Schema::table('energy_sales', function (Blueprint $table) {
            $table->foreignId('org_id')->nullable()->constrained('organizations')->nullOnDelete()->after('power_plant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plant_output', function (Blueprint $table) {
            $table->dropForeign(['org_id']);
            $table->dropColumn('org_id');
        });

        Schema::table('energy_sales', function (Blueprint $table) {
            $table->dropForeign(['org_id']);
            $table->dropColumn('org_id');
        });
    }
};
