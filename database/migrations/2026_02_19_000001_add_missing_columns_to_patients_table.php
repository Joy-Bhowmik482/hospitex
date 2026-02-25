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
        Schema::table('patients', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('patients', 'insurance_provider')) {
                $table->string('insurance_provider')->nullable();
            }
            if (!Schema::hasColumn('patients', 'insurance_id')) {
                $table->string('insurance_id')->nullable();
            }
            if (!Schema::hasColumn('patients', 'date_admitted')) {
                $table->date('date_admitted')->nullable();
            }
            if (!Schema::hasColumn('patients', 'status')) {
                $table->enum('status', ['In', 'Out', 'Discharged'])->default('In');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumnIfExists('insurance_provider');
            $table->dropColumnIfExists('insurance_id');
            $table->dropColumnIfExists('date_admitted');
            $table->dropColumnIfExists('status');
        });
    }
};
