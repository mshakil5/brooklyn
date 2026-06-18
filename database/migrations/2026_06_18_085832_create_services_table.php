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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle');
            $table->string('slug')->unique()->nullable();
            $table->string('icon')->default('bi bi-wrench');
            $table->string('badge')->nullable();
            $table->string('badge_type')->default('default');
            $table->string('badge_class')->default('');   // "urgent" or empty
            $table->string('heading');
            $table->text('description');
            $table->text('description_two')->nullable();
            $table->json('features')->nullable();
            $table->string('image')->nullable();
            $table->string('urgent_tag')->nullable();   
            $table->string('btn_text')->default('Get Free Estimate');
            $table->string('btn_link')->nullable();
            $table->integer('serial')->default(1);
            $table->boolean('status')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }


};
