<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insurance_providers', function (Blueprint $table) {
            if (! Schema::hasColumn('insurance_providers', 'code')) {
                $table->string('code')->unique()->after('name');
            }
            if (! Schema::hasColumn('insurance_providers', 'contact')) {
                $table->string('contact')->nullable()->after('code');
            }
            if (! Schema::hasColumn('insurance_providers', 'email')) {
                $table->string('email')->nullable()->after('contact');
            }
            if (! Schema::hasColumn('insurance_providers', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('insurance_providers', function (Blueprint $table) {
            if (Schema::hasColumn('insurance_providers', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('insurance_providers', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('insurance_providers', 'contact')) {
                $table->dropColumn('contact');
            }
            if (Schema::hasColumn('insurance_providers', 'code')) {
                $table->dropColumn('code');
            }
        });
    }
};
