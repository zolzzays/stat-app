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
        Schema::create('hr_count', function (Blueprint $table) {
            $table->id();
            $table->foreignId('power_plant_id')->constrained('power_plants')->onDelete('cascade');
            $table->foreignId('org_id')->nullable()->constrained('organizations')->nullOnDelete();
            $table->smallInteger('year');
            $table->tinyInteger('month');
            $table->integer('emp_male')->default(0);
            $table->integer('emp_female')->default(0);
            $table->integer('work_male')->default(0);
            $table->integer('work_female')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_count');
    }
};
