<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Exception;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:admin');
    }

    /**
     * Display the backup management page
     */
    public function index()
    {
        // Get list of existing backups
        $backups = Storage::disk('local')->allFiles('backups');
        $backupList = [];

        foreach ($backups as $backup) {
            if (pathinfo($backup, PATHINFO_EXTENSION) === 'sql') {
                $backupList[] = [
                    'name' => basename($backup),
                    'path' => $backup,
                    'size' => Storage::disk('local')->size($backup),
                    'modified' => Storage::disk('local')->lastModified($backup),
                ];
            }
        }

        // Sort by modification date (newest first)
        usort($backupList, function ($a, $b) {
            return $b['modified'] <=> $a['modified'];
        });

        return view('admin.backups.index', compact('backupList'));
    }

    /**
     * Create a new database backup
     */
    public function store(Request $request)
    {
        try {
            // Create backup directory if it doesn't exist
            if (!Storage::disk('local')->exists('backups')) {
                Storage::disk('local')->makeDirectory('backups');
            }

            // Generate backup filename with timestamp
            $filename = 'manual_backup_' . date('Y-m-d_H-i-s') . '.sql';
            $filepath = 'backups/' . $filename;

            // Get database connection details
            $connection = config('database.default');
            $dbConfig = config("database.connections.{$connection}");

            // For SQLite database
            if ($connection === 'sqlite') {
                $dbPath = $dbConfig['database'];
                if (file_exists($dbPath)) {
                    $backupContent = file_get_contents($dbPath);
                    Storage::disk('local')->put($filepath, $backupContent);
                } else {
                    throw new Exception('Database file not found');
                }
            }
            // For MySQL database — use Symfony Process to prevent command injection
            elseif ($connection === 'mysql') {
                $backupContent = $this->exportMySQLDatabase($dbConfig);
                Storage::disk('local')->put($filepath, $backupContent);
            } else {
                throw new Exception('Unsupported database type for backup');
            }

            return redirect()->route('admin.backups.index')
                ->with('success', __('Database backup created successfully'));
        } catch (Exception $e) {
            Log::error('Backup creation failed: ' . $e->getMessage());
            return redirect()->route('admin.backups.index')
                ->with('error', __('Failed to create database backup.'));
        }
    }

    /**
     * Export MySQL database using PDO (safe, no shell commands)
     */
    private function exportMySQLDatabase($dbConfig)
    {
        $host = $dbConfig['host'];
        $database = $dbConfig['database'];
        $username = $dbConfig['username'];
        $password = $dbConfig['password'];
        $port = $dbConfig['port'] ?? 3306;
        
        try {
            $pdo = new \PDO(
                "mysql:host={$host};port={$port};dbname={$database}",
                $username,
                $password
            );
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            $output = "-- Database backup\n";
            $output .= "-- Generated on " . date('Y-m-d H:i:s') . "\n";
            $output .= "-- Database: {$database}\n\n";
            $output .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
            
            // Get all tables
            $tables = $pdo->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);
            
            foreach ($tables as $table) {
                $output .= "\n-- Table structure for table `{$table}`\n";
                $output .= "DROP TABLE IF EXISTS `{$table}`;\n";
                $createTable = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
                $output .= $createTable['Create Table'] . ";\n\n";
                
                // Get table data
                $output .= "-- Data for table `{$table}`\n";
                $rows = $pdo->query("SELECT * FROM `{$table}`")->fetchAll(\PDO::FETCH_ASSOC);
                
                foreach ($rows as $row) {
                    $values = array_map(function($value) use ($pdo) {
                        if ($value === null) {
                            return 'NULL';
                        }
                        return $pdo->quote($value);
                    }, $row);
                    
                    $columns = array_map(function($col) {
                        return "`{$col}`";
                    }, array_keys($row));
                    
                    $output .= "INSERT INTO `{$table}` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");\n";
                }
                
                $output .= "\n";
            }
            
            $output .= "SET FOREIGN_KEY_CHECKS=1;\n";
            
            return $output;
        } catch (Exception $e) {
            throw new Exception('Error exporting database: ' . $e->getMessage());
        }
    }

    /**
     * Download a backup file
     */
    public function download($filename)
    {
        // Sanitize filename — prevent path traversal
        $filename = basename($filename);
        $filepath = 'backups/' . $filename;
        
        if (!Storage::disk('local')->exists($filepath)) {
            return redirect()->route('admin.backups.index')
                ->with('error', __('Backup file not found'));
        }

        return Storage::disk('local')->download($filepath, $filename);
    }

    /**
     * Restore database from backup
     */
    public function restore($filename, Request $request)
    {
        try {
            // Sanitize filename — prevent path traversal
            $filename = basename($filename);
            $filepath = 'backups/' . $filename;
            
            if (!Storage::disk('local')->exists($filepath)) {
                return redirect()->route('admin.backups.index')
                    ->with('error', __('Backup file not found'));
            }

            // Get database connection details
            $connection = config('database.default');
            $dbConfig = config("database.connections.{$connection}");

            // For SQLite database
            if ($connection === 'sqlite') {
                $dbPath = $dbConfig['database'];
                $backupContent = Storage::disk('local')->get($filepath);
                file_put_contents($dbPath, $backupContent);
            }
            // For MySQL database
            elseif ($connection === 'mysql') {
                $backupContent = Storage::disk('local')->get($filepath);
                $this->importMySQLDatabase($dbConfig, $backupContent);
            } else {
                throw new Exception('Unsupported database type for restore');
            }

            return redirect()->route('admin.backups.index')
                ->with('success', __('Database restored successfully'));
        } catch (Exception $e) {
            Log::error('Database restore failed: ' . $e->getMessage());
            return redirect()->route('admin.backups.index')
                ->with('error', __('Failed to restore database.'));
        }
    }

    /**
     * Import MySQL database using PDO (safe, no shell commands)
     */
    private function importMySQLDatabase($dbConfig, $backupContent)
    {
        $host = $dbConfig['host'];
        $database = $dbConfig['database'];
        $username = $dbConfig['username'];
        $password = $dbConfig['password'];
        $port = $dbConfig['port'] ?? 3306;
        
        try {
            $pdo = new \PDO(
                "mysql:host={$host};port={$port};dbname={$database}",
                $username,
                $password
            );
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            // Split the SQL content into statements
            $statements = array_filter(array_map('trim', explode(';', $backupContent)));
            
            $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
            
            foreach ($statements as $statement) {
                if (!empty($statement) && !str_starts_with($statement, '--')) {
                    $pdo->exec($statement);
                }
            }
            
            $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
        } catch (Exception $e) {
            throw new Exception('Error importing database: ' . $e->getMessage());
        }
    }

    /**
     * Delete a backup file
     */
    public function destroy($filename)
    {
        try {
            // Sanitize filename — prevent path traversal
            $filename = basename($filename);
            $filepath = 'backups/' . $filename;
            
            if (!Storage::disk('local')->exists($filepath)) {
                return redirect()->route('admin.backups.index')
                    ->with('error', __('Backup file not found'));
            }

            Storage::disk('local')->delete($filepath);

            return redirect()->route('admin.backups.index')
                ->with('success', __('Backup deleted successfully'));
        } catch (Exception $e) {
            Log::error('Backup deletion failed: ' . $e->getMessage());
            return redirect()->route('admin.backups.index')
                ->with('error', __('Failed to delete backup.'));
        }
    }
}