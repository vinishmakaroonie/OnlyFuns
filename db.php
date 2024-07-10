<?php
$servername = "localhost";
$username = "root";  // Default MySQL user in XAMPP
$password = "";  // Default password is empty
$dbname = "hotelreservation";  // Ensure this matches the database name created in phpMyAdmin

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
