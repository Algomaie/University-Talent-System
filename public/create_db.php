<?php
// Simple script to create the SQLite database file

$dbPath = '../database/database.sqlite';

if (file_exists($dbPath)) {
    echo "Database file already exists.\n";
} else {
    if (touch($dbPath)) {
        echo "Database file created successfully at: $dbPath\n";
    } else {
        echo "Failed to create database file.\n";
        echo "Please make sure the database directory is writable.\n";
    }
}