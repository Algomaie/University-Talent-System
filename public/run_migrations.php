<?php
// Script to run database migrations

echo "Running database migrations...\n";

// Check if Laravel is installed
if (!file_exists('../vendor/autoload.php')) {
    echo "Error: Laravel dependencies not installed.\n";
    echo "Please run: composer install\n";
    exit(1);
}

// Check if database file exists
$dbPath = '../database/database.sqlite';
if (!file_exists($dbPath)) {
    echo "Error: Database file not found.\n";
    echo "Please run: php create_db.php\n";
    exit(1);
}

echo "Database file found. Running migrations...\n";

// Try to run migrations using artisan
chdir('..'); // Change to the project root directory

// Use the artisan command to run migrations
$output = [];
$returnCode = 0;

echo "Executing: php artisan migrate --force\n";
exec('php artisan migrate --force', $output, $returnCode);

foreach ($output as $line) {
    echo "$line\n";
}

if ($returnCode === 0) {
    echo "\nMigrations completed successfully!\n";
} else {
    echo "\nMigrations failed with return code: $returnCode\n";
    echo "Please check the error messages above.\n";
}