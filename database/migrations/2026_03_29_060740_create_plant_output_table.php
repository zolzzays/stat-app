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
         Schema::create('plant_output', function (Blueprint $table) {
            $table->id();
            $table->foreignId('power_plant_id')->constrained('power_plants')->onDelete('cascade'); // relationship
            $table->string('product_name');
            $table->string('unit_name');
            $table->integer('before_month')->default(0);
            $table->integer('this_month')->default(0);
            $table->integer('year_usage')->default(0);
            $table->integer('this_musage')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_output');
    }
};
