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
        Schema::create('about_certs', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('title')->nullable();
            $table->string('license_label')->nullable(); // "License #", "Status", "Coverage"
            $table->string('license_number')->nullable();
            $table->string('license_class')->default(''); // "approved", empty
            $table->text('description')->nullable();
            $table->string('status_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_certs');
    }
};
