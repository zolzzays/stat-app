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
        Schema::table('power_plants', function (Blueprint $table) {
            $table->foreignId('org_id')->nullable()->constrained('organizations')->nullOnDelete()->after('plant_name');
            $table->foreignId('reg_type_id')->nullable()->constrained('reg_types')->nullOnDelete()->after('org_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('power_plants', function (Blueprint $table) {
            $table->dropForeign(['org_id']);
            $table->dropForeign(['reg_type_id']);
            $table->dropColumn(['org_id', 'reg_type_id']);
        });
    }
};
