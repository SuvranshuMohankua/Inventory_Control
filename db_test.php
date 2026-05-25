<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "inventory_control";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to MySQL server\n";
    
    $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "Database check/creation done\n";
    
    $conn->exec("USE $dbname");
    echo "Using database $dbname\n";
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
