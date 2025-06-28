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
        Schema::table('jobs', function(Blueprint $table){
            $table->boolean("isFeatured")->default(0)->comment("1 for featured and 0 for not featured : default 0")->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('jobs', function(Blueprint $table){
            $table->boolean("isFeatured")->default(1)->change();
        });
    }
};
