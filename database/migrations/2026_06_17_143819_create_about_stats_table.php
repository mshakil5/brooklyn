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
        Schema::create('about_stats', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable(); // bi-building, bi-calendar-check, etc.
            $table->string('number')->nullable(); // 5,000+, 25+, etc.
            $table->string('label')->nullable(); // Projects Done, Years Experience, etc.
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_stats');
    }
};
