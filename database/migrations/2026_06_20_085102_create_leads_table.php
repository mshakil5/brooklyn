<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            
            // Form Data
            $table->string('address')->nullable(); 
            $table->string('first_name')->nullable(); 
            $table->string('phone')->nullable(); 
            $table->string('email')->nullable(); 
            
            // API & Calculated Data
            $table->string('status')->default('success'); // danger, warning, success
            $table->integer('risk_score')->default(0);
            $table->integer('dot_tickets_count')->default(0);
            $table->integer('dob_complaints_count')->default(0);
            
            // JSON Data (Stores arrays/objects cleanly)
            $table->json('risk_details')->nullable(); 
            $table->json('api_raw_data')->nullable(); // Stores the exact API response for your records
            
            // CRM Helper
            $table->boolean('is_contacted')->default(false); // Check off when you call them
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leads');
    }
};