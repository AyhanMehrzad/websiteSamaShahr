<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sama";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // You can comment out the echo in production
    echo "Connection failed: " . $e->getMessage();
}
echo"DB_connect is working.";
?> 