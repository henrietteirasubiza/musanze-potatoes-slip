<?php
// config/database.php
// Database connection configuration

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Change to your DB user
define('DB_PASS', '');           // Change to your DB password
define('DB_NAME', 'musanze_market');
define('DB_CHARSET', 'utf8mb4');

function getDBConnection(): mysqli {
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            error_log('Database connection failed: ' . $conn->connect_error);
            die(json_encode(['error' => 'Database connection failed. Please check configuration.']));
        }
        $conn->set_charset(DB_CHARSET);
    }
    return $conn;
}
