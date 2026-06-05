<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('study_sessions', function () {
            DB::statement("ALTER TABLE study_sessions MODIFY COLUMN status ENUM('upcoming', 'in_progress', 'full', 'completed') DEFAULT 'upcoming'");
        });
    }

    public function down(): void
    {
        Schema::table('study_sessions', function () {
            DB::statement("ALTER TABLE study_sessions MODIFY COLUMN status ENUM('upcoming', 'in_progress', 'full') DEFAULT 'upcoming'");
        });
    }
};
