<?php
    $host = 'localhost'; // Database host
    $dbname = 'users_db'; // Database name
    $username = 'root'; // Database username
    $password = ''; // Database password

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;", $username, $password);

        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
    } catch (PDOException $e) {
        // Handle connection error
        die("Database connection failed: " . $e->getMessage());
    }
?>