<?php  

    // Docker environment detection
    $isDocker = getenv('DB_HOST') !== false;
    
    if ($isDocker) {
        // Docker environment
        $servername = getenv('DB_HOST') ?: 'db';
        $username = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASSWORD') ?: 'rootpassword';
        $database = getenv('DB_NAME') ?: 'threadhub';
    } else {
        // Local development environment
        $servername = "localhost";
        $username = "root";
        $password = "Heera@978663";
        $database = "threadni";
    }

    $conn = mysqli_connect($servername, $username, $password, $database);
    if(!$conn) {
        die("Failed to connect to the database: " . mysqli_connect_error());
    }
        
?>