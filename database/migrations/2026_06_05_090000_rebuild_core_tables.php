<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // Drop old tables in reverse dependency order
        Schema::dropIfExists('session_user');
        Schema::dropIfExists('attendance_records');
        Schema::dropIfExists('group_chat_messages');
        Schema::dropIfExists('help_request_responses');

        // Drop FK on ratings before dropping study_sessions
        if (Schema::hasTable('ratings')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropForeign(['study_session_id']);
            });
        }

        Schema::dropIfExists('study_sessions');

        // Rename ratings columns to match spec
        if (Schema::hasTable('ratings')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->renameColumn('study_session_id', 'study_group_id');
                $table->renameColumn('rating', 'rating_stars');
                $table->renameColumn('feedback', 'feedback_text');
            });
        }

        // -- study_groups --
        Schema::create('study_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('course_code');
            $table->string('topic');
            $table->string('location');
            $table->date('date');
            $table->time('time');
            $table->integer('participant_limit');
            $table->integer('joined_count')->default(0);
            $table->string('material_path')->nullable();
            $table->string('status')->default('upcoming');
            $table->timestamps();
        });

        // Restore FK from ratings to study_groups
        Schema::table('ratings', function (Blueprint $table) {
            $table->foreign('study_group_id')->references('id')->on('study_groups')->cascadeOnDelete();
        });

        // -- replies --
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('help_request_id')->constrained()->cascadeOnDelete();
            $table->string('student_name');
            $table->text('reply_text');
            $table->timestamps();
        });

        // -- group_chats --
        Schema::create('group_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_group_id')->constrained('study_groups')->cascadeOnDelete();
            $table->string('student_name');
            $table->text('message_text');
            $table->timestamps();
        });

        // -- attendances --
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_group_id')->constrained('study_groups')->cascadeOnDelete();
            $table->string('student_matric');
            $table->boolean('attended')->default(false);
            $table->timestamps();
        });

        // -- group_user pivot --
        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('study_groups')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unique(['group_id', 'user_id']);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('group_user');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('group_chats');
        Schema::dropIfExists('replies');

        // Restore ratings columns only if they exist
        if (Schema::hasTable('ratings') && Schema::hasColumn('ratings', 'study_group_id')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropForeign(['study_group_id']);
            });
        }
        if (Schema::hasTable('ratings')) {
            Schema::table('ratings', function (Blueprint $table) {
                if (Schema::hasColumn('ratings', 'study_group_id')) {
                    $table->renameColumn('study_group_id', 'study_session_id');
                }
                if (Schema::hasColumn('ratings', 'rating_stars')) {
                    $table->renameColumn('rating_stars', 'rating');
                }
                if (Schema::hasColumn('ratings', 'feedback_text')) {
                    $table->renameColumn('feedback_text', 'feedback');
                }
            });
        }

        Schema::dropIfExists('study_groups');

        Schema::enableForeignKeyConstraints();
    }
};
