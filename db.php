<?php
$host = "localhost";
$username = "root"; // Replace with your database username
$password = "";     // Replace with your database password
$dbname = "DairyManagementSystem"; // Database name

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
