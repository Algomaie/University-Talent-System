<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the notifications table exists before trying to rename it
        if (Schema::hasTable('notifications')) {
            Schema::rename('notifications', 'system_notifications');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the system_notifications table exists before trying to rename it back
        if (Schema::hasTable('system_notifications')) {
            Schema::rename('system_notifications', 'notifications');
        }
    }
};