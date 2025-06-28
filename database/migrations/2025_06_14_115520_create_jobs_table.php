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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_type_id')->constrained()->cascadeOnDelete();
            $table->integer('vacancy');
            $table->string('salary');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->text('benifits')->nullable();
            $table->text('responsibility')->nullable();
            $table->text('qualifications')->nullable();
            $table->string('keywords')->nullable();
            $table->string('company_name');
            $table->string('company_location');
            $table->string('company_website');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
