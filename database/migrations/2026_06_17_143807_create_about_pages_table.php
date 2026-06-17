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
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            
            // Hero Section
            $table->string('hero_tag')->default('Our Story');
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            
            // Story Section
            $table->string('story_tag')->default('Our Journey');
            $table->string('story_title')->nullable();
            $table->longText('story_content')->nullable();
            $table->string('story_image')->nullable();
            $table->string('badge_rating')->default('A+');
            $table->string('badge_label')->default('BBB Accredited');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_pages');
    }
};
