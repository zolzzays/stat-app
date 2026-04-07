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
        Schema::table('energy_sales', function (Blueprint $table) {
            $table->decimal('before_sal', 15, 2)->default(0)->after('before_month');
            $table->decimal('this_sal',   15, 2)->default(0)->after('this_month');
            $table->decimal('year_sal',   15, 2)->default(0)->after('year_usage');
            $table->decimal('this_msal',  15, 2)->default(0)->after('this_musage');
        });
    }

    public function down(): void
    {
        Schema::table('energy_sales', function (Blueprint $table) {
            $table->dropColumn(['before_sal', 'this_sal', 'year_sal', 'this_msal']);
        });
    }
};
