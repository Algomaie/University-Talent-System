<?php
// Manual user creation script for testing

require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\Hash;

echo "Manual User Creation Test\n";
echo "========================\n\n";

try {
    // Load Laravel application
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    // Bootstrap the application
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "Laravel application loaded successfully.\n";
    
    // Try to create a user directly
    $userData = [
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
    ];
    
    // Check if user already exists
    $existingUser = \App\Models\User::where('email', 'test@example.com')->first();
    
    if ($existingUser) {
        echo "User already exists with ID: {$existingUser->id}\n";
    } else {
        // Create the user
        $user = \App\Models\User::create($userData);
        echo "User created successfully with ID: {$user->id}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
} catch (Error $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

echo "\nTest completed.\n";