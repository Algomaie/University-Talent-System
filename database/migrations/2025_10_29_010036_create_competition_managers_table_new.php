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
        // Check if columns exist before adding them
        if (!Schema::hasColumn('competition_managers', 'competition_id')) {
            Schema::table('competition_managers', function (Blueprint $table) {
                $table->foreignId('competition_id')->constrained()->onDelete('cascade')->after('id');
            });
        }
        
        if (!Schema::hasColumn('competition_managers', 'user_id')) {
            Schema::table('competition_managers', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade')->after('competition_id');
            });
        }
        
        if (!Schema::hasColumn('competition_managers', 'role')) {
            Schema::table('competition_managers', function (Blueprint $table) {
                $table->string('role')->default('manager')->after('user_id');
            });
        }
        
        // Add unique constraint if it doesn't exist
        if (!Schema::hasIndex('competition_managers', 'competition_managers_competition_id_user_id_unique')) {
            Schema::table('competition_managers', function (Blueprint $table) {
                $table->unique(['competition_id', 'user_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competition_managers', function (Blueprint $table) {
            $table->dropForeign(['competition_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['competition_id', 'user_id', 'role']);
            $table->dropUnique(['competition_id', 'user_id']);
        });
    }
};