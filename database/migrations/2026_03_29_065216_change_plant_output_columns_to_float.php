<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plant_output', function (Blueprint $table) {
            // Integer багануудыг float болгож өөрчлөх
            $table->float('before_month', 10, 2)->default(0)->change();
            $table->float('this_month', 10, 2)->default(0)->change();
            $table->float('year_usage', 10, 2)->default(0)->change();
            $table->float('this_musage', 10, 2)->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('plant_output', function (Blueprint $table) {
            // Буцааж integer болгох
            $table->integer('before_month')->default(0)->change();
            $table->integer('this_month')->default(0)->change();
            $table->integer('year_usage')->default(0)->change();
            $table->integer('this_musage')->default(0)->change();
        });
    }
};