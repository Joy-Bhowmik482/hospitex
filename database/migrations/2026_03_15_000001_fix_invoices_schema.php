<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add department column and ensure schema is consistent
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Add department column if it doesn't exist
            if (!Schema::hasColumn('invoices', 'department')) {
                $table->string('department')->nullable()->after('notes');
            }

            // Add indexes for better query performance
            if (!Schema::hasColumn('invoices', 'status')) {
                // Column already exists, just add index
            } else {
                // No need to modify the column itself, just ensure indexes exist
            }
        });

        // Add indexes for frequently queried columns
        Schema::table('invoices', function (Blueprint $table) {
            // Check if indexes exist before adding
            $indexes = \DB::select("SHOW INDEX FROM invoices WHERE Key_name IN ('invoices_status_index', 'invoices_invoice_date_index', 'invoices_patient_id_index')");
            $indexNames = collect($indexes)->pluck('Key_name')->unique()->toArray();

            if (!in_array('invoices_status_index', $indexNames)) {
                $table->index('status');
            }
            if (!in_array('invoices_invoice_date_index', $indexNames)) {
                $table->index('invoice_date');
            }
            if (!in_array('invoices_patient_id_index', $indexNames)) {
                $table->index('patient_id');
            }
        });
    }

    /**
     * Revert the changes
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Drop department column
            if (Schema::hasColumn('invoices', 'department')) {
                $table->dropColumn('department');
            }

            // Drop indexes
            $table->dropIndex('invoices_status_index');
            $table->dropIndex('invoices_invoice_date_index');
            $table->dropIndex('invoices_patient_id_index');
        });
    }
};
