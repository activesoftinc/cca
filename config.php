<?php
// Database connection
$host = "localhost";  // Update with your database host
$db = "credit_card_affiliates";  // Update with your database name
$user = "root";  // Update with your database user
$pass = "";  // Update with your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
