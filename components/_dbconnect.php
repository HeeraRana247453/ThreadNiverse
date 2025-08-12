<?php  

// Load environment variables
if (file_exists(__DIR__ . '/../.env')) {
    $env = parse_ini_file(__DIR__ . '/../.env');
} else {
    $env = [];
}

// Docker environment detection
$isDocker = getenv('DB_HOST') !== false;

if ($isDocker) {
    // Docker environment
    $servername = getenv('DB_HOST') ?: 'db';
    $username = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASSWORD') ?: 'rootpassword';
    $database = getenv('DB_NAME') ?: 'threadhub';
} else {
    // Local development environment using .env file
    $servername = $env['DB_HOST'] ?? 'localhost';
    $username = $env['DB_USER'] ?? 'root';
    $password = $env['DB_PASSWORD'] ?? '';
    $database = $env['DB_NAME'] ?? 'threadni';
}

$conn = mysqli_connect($servername, $username, $password, $database);
if(!$conn) {
    die("Failed to connect to the database: " . mysqli_connect_error());
}
        
?>
