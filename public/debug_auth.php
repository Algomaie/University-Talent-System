<?php
// Debug authentication issues

require_once __DIR__ . '/../vendor/autoload.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Authentication Debug</title>
    <script src='https://cdn.tailwindcss.com'></script>
</head>
<body class='bg-gray-100'>
    <div class='min-h-screen flex items-center justify-center'>
        <div class=p-8 rounded-lg shadow-md w-full max-w-2xl'>
            <h1 class='text-3xl font-bold text-center text-gray-900 style=" color: black !important;" mb-6'>Authentication Debug</h1>";

try {
    // Load Laravel application
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    // Bootstrap the application
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4'>
            <p><strong>Success:</strong> Laravel application loaded successfully.</p>
          </div>";
    
    // Check if we can access the database
    try {
        $db = \Illuminate\Support\Facades\DB::connection();
        echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4'>
                <p><strong>Database:</strong> Connection successful.</p>
              </div>";
    } catch (Exception $e) {
        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4'>
                <p><strong>Database Error:</strong> " . $e->getMessage() . "</p>
              </div>";
    }
    
    // Check if sessions table exists
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('sessions')) {
            echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4'>
                    <p><strong>Sessions Table:</strong> Exists.</p>
                  </div>";
        } else {
            echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4'>
                    <p><strong>Sessions Table:</strong> Does not exist.</p>
                  </div>";
        }
    } catch (Exception $e) {
        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4'>
                <p><strong>Sessions Table Error:</strong> " . $e->getMessage() . "</p>
              </div>";
    }
    
    // Check if users table exists
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
            echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4'>
                    <p><strong>Users Table:</strong> Exists.</p>
                  </div>";
        } else {
            echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4'>
                    <p><strong>Users Table:</strong> Does not exist.</p>
                  </div>";
        }
    } catch (Exception $e) {
        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4'>
                <p><strong>Users Table Error:</strong> " . $e->getMessage() . "</p>
              </div>";
    }
    
    // Try to get a user
    try {
        $user = \App\Models\User::first();
        if ($user) {
            echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4'>
                    <p><strong>User Found:</strong> ID {$user->id}, Name {$user->name}, Email {$user->email}</p>
                  </div>";
        } else {
            echo "<div class='bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4'>
                    <p><strong>No Users:</strong> Database is empty.</p>
                  </div>";
        }
    } catch (Exception $e) {
        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4'>
                <p><strong>User Query Error:</strong> " . $e->getMessage() . "</p>
              </div>";
    }
    
    // Check auth configuration
    try {
        $authConfig = config('auth');
        echo "<div class='bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4'>
                <p><strong>Auth Config:</strong> Loaded successfully.</p>
                <p>Default guard: " . ($authConfig['defaults']['guard'] ?? 'N/A') . "</p>
                <p>Default passwords: " . ($authConfig['defaults']['passwords'] ?? 'N/A') . "</p>
              </div>";
    } catch (Exception $e) {
        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4'>
                <p><strong>Auth Config Error:</strong> " . $e->getMessage() . "</p>
              </div>";
    }
    
    // Check permission configuration
    try {
        $permissionConfig = config('permission');
        echo "<div class='bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4'>
                <p><strong>Permission Config:</strong> Loaded successfully.</p>
              </div>";
    } catch (Exception $e) {
        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4'>
                <p><strong>Permission Config Error:</strong> " . $e->getMessage() . "</p>
              </div>";
    }
    
} catch (Exception $e) {
    echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4'>
            <p><strong>Error:</strong> " . $e->getMessage() . "</p>
            <p>File: " . $e->getFile() . "</p>
            <p>Line: " . $e->getLine() . "</p>
          </div>";
} catch (Error $e) {
    echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4'>
            <p><strong>Error:</strong> " . $e->getMessage() . "</p>
            <p>File: " . $e->getFile() . "</p>
            <p>Line: " . $e->getLine() . "</p>
          </div>";
}

echo "<div class='mt-6 text-center'>
        <a href='/' class='text-indigo-600 hover:text-indigo-800'>Back to Main Application</a>
      </div>
    </div>
</body>
</html>";
?>