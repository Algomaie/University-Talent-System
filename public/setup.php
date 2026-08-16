<?php
// Setup script for the Student Talents System
// This script helps with initial setup and creating test users

echo "Student Talents System Setup Script\n";
echo "==================================\n\n";

// Check if we're in the correct directory
if (!file_exists('../artisan')) {
    echo "Error: This script must be run from the public directory of the Laravel project.\n";
    exit(1);
}

// Function to execute a command and return output
function runCommand($command) {
    echo "Running: $command\n";
    $output = [];
    $returnCode = 0;
    exec($command, $output, $returnCode);
    
    foreach ($output as $line) {
        echo "  $line\n";
    }
    
    if ($returnCode !== 0) {
        echo "  Command failed with return code: $returnCode\n";
        return false;
    }
    
    echo "  Command completed successfully.\n\n";
    return true;
}

// Check if composer dependencies are installed
echo "1. Checking Composer dependencies...\n";
if (!file_exists('../vendor/autoload.php')) {
    echo "  Composer dependencies not found.\n";
    echo "  Please run: composer install\n\n";
} else {
    echo "  Composer dependencies are installed.\n\n";
}

// Check if NPM dependencies are installed
echo "2. Checking NPM dependencies...\n";
if (!file_exists('../node_modules')) {
    echo "  NPM dependencies not found.\n";
    echo "  Please run: npm install\n\n";
} else {
    echo "  NPM dependencies are installed.\n\n";
}

// Check database configuration
echo "3. Checking database configuration...\n";
$dbPath = '../database/database.sqlite';
if (!file_exists($dbPath)) {
    echo "  SQLite database file not found.\n";
    echo "  Creating database file...\n";
    if (touch($dbPath)) {
        echo "  Database file created successfully.\n\n";
    } else {
        echo "  Failed to create database file.\n\n";
    }
} else {
    echo "  SQLite database file exists.\n\n";
}

// Offer to create a test user
echo "4. Test User Creation\n";
echo "   Would you like to create a test user? (y/n): ";

$handle = fopen("php://stdin", "r");
$line = fgets($handle);
fclose($handle);

if (trim(strtolower($line)) === 'y') {
    echo "\n  Creating test user...\n";
    
    // Check if Laravel is properly set up
    if (!file_exists('../vendor/autoload.php')) {
        echo "  Error: Laravel dependencies not installed. Please run 'composer install' first.\n";
    } else {
        require_once '../vendor/autoload.php';
        
        try {
            // Load Laravel application
            $app = require_once '../bootstrap/app.php';
            
            // Bootstrap the application
            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();
            
            // Check if User model exists
            if (class_exists('App\Models\User')) {
                // Check if user already exists
                $existingUser = \App\Models\User::where('email', 'test@example.com')->first();
                
                if ($existingUser) {
                    echo "  Test user already exists!\n";
                    echo "  Email: test@example.com\n";
                    echo "  Password: password\n";
                } else {
                    // Create test user
                    $user = \App\Models\User::create([
                        'name' => 'Test User',
                        'email' => 'test@example.com',
                        'password' => \Illuminate\Support\Facades\Hash::make('password'),
                        'role' => 'student',
                        'student_id' => 'STU001',
                        'department' => 'Computer Science',
                        'academic_level' => 'Third Year',
                        'phone' => '1234567890',
                        'is_active' => 1,
                        'email_verified_at' => now(),
                    ]);
                    
                    echo "  Test user created successfully!\n";
                    echo "  User ID: {$user->id}\n";
                    echo "  Email: test@example.com\n";
                    echo "  Password: password\n";
                    echo "  Role: student\n";
                }
            } else {
                echo "  Error: User model not found.\n";
            }
        } catch (Exception $e) {
            echo "  Error creating user: " . $e->getMessage() . "\n";
            echo "  Please make sure you have run the migrations first:\n";
            echo "  php artisan migrate\n";
        } catch (Error $e) {
            echo "  Error creating user: " . $e->getMessage() . "\n";
            echo "  Please make sure you have run the following commands:\n";
            echo "  1. composer install\n";
            echo "  2. php artisan migrate\n";
        }
    }
}

echo "\nSetup script completed.\n";
echo "To complete the setup, please run the following commands:\n";
echo "1. composer install\n";
echo "2. npm install\n";
echo "3. php artisan migrate\n";
echo "4. php artisan db:seed (optional)\n";
echo "5. npm run build\n";
echo "6. php artisan serve\n";