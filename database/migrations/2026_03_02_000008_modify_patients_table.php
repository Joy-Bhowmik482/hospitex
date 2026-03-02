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
            // remove unused columns
            if (Schema::hasColumn('patients', 'city')) {
                $table->dropColumn('city');
            }
            if (Schema::hasColumn('patients', 'state')) {
                $table->dropColumn('state');
            }
            if (Schema::hasColumn('patients', 'postal_code')) {
                $table->dropColumn('postal_code');
            }
            if (Schema::hasColumn('patients', 'insurance_provider')) {
                $table->dropColumn('insurance_provider');
            }
            if (Schema::hasColumn('patients', 'insurance_id')) {
                $table->dropColumn('insurance_id');
            }

            // add note column
            $table->text('notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // add removed columns back
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('insurance_provider')->nullable();
            $table->string('insurance_id')->nullable();

            // drop notes
            $table->dropColumn('notes');
        });
    }
};
