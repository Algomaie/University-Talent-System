<?php
// Simple script to create a user account for testing
// This should only be used for development purposes

// Check if Laravel is installed
if (!file_exists('../vendor/autoload.php')) {
    echo "Laravel dependencies not installed. Please run:\n";
    echo "composer install\n";
    exit(1);
}

require_once '../vendor/autoload.php';

use Illuminate\Support\Facades\Hash;

// Load Laravel application
$app = require_once '../bootstrap/app.php';

// Create the database file if it doesn't exist
$dbPath = '../database/database.sqlite';
if (!file_exists($dbPath)) {
    touch($dbPath);
    echo "Created database file: $dbPath\n";
}

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check if database is set up
try {
    // Try to use the User model
    if (!class_exists('App\Models\User')) {
        echo "App\Models\User class not found. Please check your setup.\n";
        exit(1);
    }
    
    // Check if users table exists by trying to query it
    $userCount = \App\Models\User::count();
    
    // If we get here, the table exists. Now check if our test user exists
    $existingUser = \App\Models\User::where('email', 'test@example.com')->first();
    
    if ($existingUser) {
        echo "Test user already exists!\n";
        echo "Email: test@example.com\n";
        echo "Password: password\n";
        exit(0);
    }
    
    // Create a test user
    $user = \App\Models\User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
        'role' => 'student',
        'student_id' => 'STU001',
        'department' => 'Computer Science',
        'academic_level' => 'Third Year',
        'phone' => '1234567890',
        'is_active' => 1,
        'email_verified_at' => now(),
    ]);
    
    echo "Test user created successfully!\n";
    echo "User ID: {$user->id}\n";
    echo "Email: test@example.com\n";
    echo "Password: password\n";
    echo "Role: student\n";
    echo "\nYou can now log in to the application with these credentials.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Please make sure you have run the migrations first:\n";
    echo "php artisan migrate\n";
    exit(1);
} catch (Error $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Please make sure you have run the following commands:\n";
    echo "1. composer install\n";
    echo "2. php artisan migrate\n";
    echo "3. php artisan db:seed (optional)\n";
    exit(1);
}