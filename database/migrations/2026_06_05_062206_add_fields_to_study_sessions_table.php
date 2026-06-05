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
        Schema::table('study_sessions', function (Blueprint $table) {
            $table->date('session_date')->nullable()->after('location');
            $table->time('session_time')->nullable()->after('session_date');
            $table->integer('joined_count')->default(0)->after('available_slots');
            $table->enum('status', ['upcoming', 'in_progress', 'full'])->default('upcoming')->after('joined_count');
        });
    }

    public function down(): void
    {
        Schema::table('study_sessions', function (Blueprint $table) {
            $table->dropColumn(['session_date', 'session_time', 'joined_count', 'status']);
        });
    }
};
