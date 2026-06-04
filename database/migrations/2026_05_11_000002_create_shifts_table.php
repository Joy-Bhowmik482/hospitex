<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('shifts')->insert([
            ['name' => 'Morning', 'start_time' => '07:00:00', 'end_time' => '15:00:00', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Evening', 'start_time' => '15:00:00', 'end_time' => '23:00:00', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Night', 'start_time' => '23:00:00', 'end_time' => '07:00:00', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
