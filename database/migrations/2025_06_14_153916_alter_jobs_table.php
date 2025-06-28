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
        Schema::table('jobs', function(Blueprint $table) {
            $table->boolean('status')->default(1)->comment('1 for published and 0 for draft')->after('keywords');
            $table->boolean('isFeatured')->default(1)->comment('1 for featured and 0 for not featured')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function(Blueprint $table){
            $table->dropColumn('status');
            $table->dropColumn('isFeatured');
        });
    }
};
