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
        Schema::table('activity_logs', function (Blueprint $table) {
            // Make old columns nullable since we're using new fields instead
            $table->string('module')->nullable()->change();
            $table->string('record_type')->nullable()->change();
            $table->string('record_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            // Revert nullable changes
            $table->string('module')->nullable(false)->change();
            $table->string('record_type')->nullable(false)->change();
            $table->string('record_id')->nullable(false)->change();
        });
    }
};
