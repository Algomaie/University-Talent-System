<?php
// Debug script for registration issues

echo "=== Registration Debug Script ===\n\n";

// Check if this is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "POST Request Detected\n";
    echo "Request Data:\n";
    print_r($_POST);
    echo "\n";
    
    // Check if CSRF token is present
    if (isset($_POST['_token'])) {
        echo "CSRF Token: Present\n";
    } else {
        echo "CSRF Token: Missing\n";
    }
    
    // Check required fields
    $required_fields = ['name', 'email', 'password', 'password_confirmation', 'role', 'student_id'];
    foreach ($required_fields as $field) {
        if (isset($_POST[$field]) && !empty($_POST[$field])) {
            echo "Field '$field': Present\n";
        } else {
            echo "Field '$field': Missing or Empty\n";
        }
    }
    
    // Check terms checkbox
    if (isset($_POST['terms'])) {
        echo "Terms: Accepted\n";
    } else {
        echo "Terms: Not Accepted\n";
    }
    
    echo "\n";
} else {
    echo "This script is meant to debug POST requests to the registration endpoint.\n";
    echo "To use it, submit the registration form and check the server logs.\n\n";
}

// Check Laravel environment
echo "=== Laravel Environment Check ===\n";

if (file_exists('../vendor/autoload.php')) {
    echo "Composer dependencies: Installed\n";
    
    require_once '../vendor/autoload.php';
    
    if (file_exists('../bootstrap/app.php')) {
        echo "Laravel bootstrap: Found\n";
        
        try {
            $app = require_once '../bootstrap/app.php';
            echo "Laravel application: Loaded\n";
            
            // Check if database is configured
            $env_file = file_exists('../.env') ? file('../.env') : [];
            $db_configured = false;
            foreach ($env_file as $line) {
                if (strpos($line, 'DB_CONNECTION') !== false && strpos($line, '=') !== false) {
                    $db_configured = true;
                    echo "Database configuration: Found (" . trim($line) . ")\n";
                    break;
                }
            }
            
            if (!$db_configured) {
                echo "Database configuration: Not found\n";
            }
            
        } catch (Exception $e) {
            echo "Laravel application error: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Laravel bootstrap: Not found\n";
    }
} else {
    echo "Composer dependencies: Not installed\n";
}

echo "\n=== Debug Complete ===\n";