<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database {--type=daily : Type of backup (daily, weekly)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a database backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $type = $this->option('type');
            $this->info("Creating {$type} database backup...");
            
            // Create backup directory if it doesn't exist
            if (!Storage::disk('local')->exists('backups')) {
                Storage::disk('local')->makeDirectory('backups');
            }

            // Generate backup filename with timestamp and type
            $filename = $type . '_backup_' . date('Y-m-d_H-i-s') . '.sql';
            $filepath = 'backups/' . $filename;
            
            // Get database connection details
            $connection = config('database.default');
            $dbConfig = config("database.connections.{$connection}");

            // For SQLite database
            if ($connection === 'sqlite') {
                $dbPath = $dbConfig['database'];
                if (file_exists($dbPath)) {
                    // Copy the SQLite database file directly
                    $backupContent = file_get_contents($dbPath);
                    Storage::disk('local')->put($filepath, $backupContent);
                    $this->info("Database backup created successfully: {$filename}");
                    Log::info("Automatic database backup created: {$filename}");
                } else {
                    throw new Exception('Database file not found');
                }
            } 
            // For MySQL database
            elseif ($connection === 'mysql') {
                // Use mysqldump to create backup
                $host = $dbConfig['host'];
                $database = $dbConfig['database'];
                $username = $dbConfig['username'];
                $password = $dbConfig['password'];
                
                // Try to use mysqldump, but handle if it's not available
                $command = "mysqldump --host={$host} --user={$username} --password={$password} {$database} 2>&1";
                
                // Execute the command and save output to file
                $backupContent = shell_exec($command);
                
                // Check if mysqldump failed
                if ($backupContent === null) {
                    // Fallback: try to export tables manually
                    $backupContent = $this->exportMySQLDatabase($dbConfig);
                }
                
                Storage::disk('local')->put($filepath, $backupContent);
                
                $this->info("Database backup created successfully: {$filename}");
                Log::info("Automatic database backup created: {$filename}");
            } else {
                throw new Exception('Unsupported database type for backup');
            }

            // Clean up old backups (keep only last 30 days of daily backups and all weekly backups)
            $this->cleanupOldBackups();
            
            return 0;
        } catch (Exception $e) {
            $this->error('Error creating database backup: ' . $e->getMessage());
            Log::error('Error creating automatic database backup: ' . $e->getMessage());
            return 1;
        }
    }
    
    /**
     * Export MySQL database manually if mysqldump is not available
     */
    private function exportMySQLDatabase($dbConfig)
    {
        $host = $dbConfig['host'];
        $database = $dbConfig['database'];
        $username = $dbConfig['username'];
        $password = $dbConfig['password'];
        
        try {
            $pdo = new \PDO("mysql:host={$host};dbname={$database}", $username, $password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            $output = "-- Database backup\n";
            $output .= "-- Generated on " . date('Y-m-d H:i:s') . "\n\n";
            
            // Get all tables
            $tables = $pdo->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);
            
            foreach ($tables as $table) {
                $output .= "\n-- Table structure for table `{$table}`\n";
                $createTable = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
                $output .= $createTable['Create Table'] . ";\n\n";
                
                // Get table data
                $output .= "-- Data for table `{$table}`\n";
                $rows = $pdo->query("SELECT * FROM `{$table}`")->fetchAll(\PDO::FETCH_ASSOC);
                
                foreach ($rows as $row) {
                    $values = array_map(function($value) use ($pdo) {
                        return $pdo->quote($value);
                    }, $row);
                    
                    $output .= "INSERT INTO `{$table}` VALUES (" . implode(', ', $values) . ");\n";
                }
                
                $output .= "\n";
            }
            
            return $output;
        } catch (Exception $e) {
            return "-- Error exporting database: " . $e->getMessage();
        }
    }
    
    /**
     * Clean up old backup files
     */
    private function cleanupOldBackups()
    {
        $backups = Storage::disk('local')->allFiles('backups');
        
        // Keep backups for 30 days
        $cutoffDate = strtotime('-30 days');
        
        foreach ($backups as $backup) {
            $modified = Storage::disk('local')->lastModified($backup);
            
            // Delete daily backups older than 30 days
            if (strpos(basename($backup), 'daily_backup_') !== false && $modified < $cutoffDate) {
                Storage::disk('local')->delete($backup);
                $this->info("Deleted old backup: " . basename($backup));
            }
        }
    }
}