<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->text('subtitle')->nullable()->after('title');
            $table->json('highlights')->nullable()->after('subtitle');
            $table->json('stats')->nullable()->after('highlights');
        });
    }

    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'highlights', 'stats']);
        });
    }

    
};
