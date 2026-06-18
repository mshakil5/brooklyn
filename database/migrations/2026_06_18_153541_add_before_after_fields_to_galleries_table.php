<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('category')->nullable()->after('type');
            $table->string('before_image')->nullable()->after('file_path');
            $table->string('after_image')->nullable()->after('before_image');
            $table->string('location')->nullable()->after('subtitle');
            $table->string('year')->nullable()->after('location');
        });
    }

    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['category', 'before_image', 'after_image', 'location', 'year']);
        });
    }
};