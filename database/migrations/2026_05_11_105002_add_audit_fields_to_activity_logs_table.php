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
            $table->text('description')->nullable()->after('action');
            $table->string('route')->nullable()->after('description');
            $table->renameColumn('ip', 'ip_address');
            $table->timestamp('login_time')->nullable()->after('user_agent');
            $table->timestamp('logout_time')->nullable()->after('login_time');
            $table->string('status')->nullable()->after('logout_time'); // active, logged_out, etc.
        });
    }

    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn(['description', 'route', 'login_time', 'logout_time', 'status']);
            $table->renameColumn('ip_address', 'ip');
        });
    }
};
