<?php
// Script to check users in the database

require_once __DIR__ . '/../vendor/autoload.php';

echo "Checking users in database...\n";
echo "============================\n\n";

try {
    // Load Laravel application
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    // Bootstrap the application
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "Laravel application loaded successfully.\n\n";
    
    // Get all users
    $users = \App\Models\User::all();
    
    echo "Total users: " . $users->count() . "\n\n";
    
    foreach ($users as $user) {
        echo "ID: {$user->id}\n";
        echo "Name: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Role: {$user->role}\n";
        echo "Student ID: {$user->student_id}\n";
        echo "Department: {$user->department}\n";
        echo "Academic Level: {$user->academic_level}\n";
        echo "Active: " . ($user->is_active ? 'Yes' : 'No') . "\n";
        echo "Created: {$user->created_at}\n";
        echo "------------------------\n";
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

echo "\nCheck completed.\n";