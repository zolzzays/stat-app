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
        Schema::create('energy_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('power_plant_id')->constrained('power_plants')->onDelete('cascade');
            $table->smallInteger('year');
            $table->tinyInteger('month');
            $table->string('product_name');
            $table->string('unit_name');
            $table->float('before_month', 10, 2)->default(0);
            $table->float('this_month', 10, 2)->default(0);
            $table->float('year_usage', 10, 2)->default(0);
            $table->float('this_musage', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('energy_sales');
    }
};
