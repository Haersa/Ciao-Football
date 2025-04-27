<?php
// Database configuration
// $host = "localhost";     // XAMPP default host
// $username = "root";      // XAMPP default username
// $password = "";          // XAMPP default password (empty)
// $database = "ciaofootball"; // Your database name

// // Create connection
// $conn = new mysqli($host, $username, $password, $database);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Set charset to ensure proper handling of special characters
// $conn->set_charset("utf8mb4");

// college connection

$conn = mysqli_connect("localhost", "HNCWEBMR11", "gjXv9H7RH6", "HNCWEBMR11")
or die('cannot connect');

// remember to download sql table files off xampp before uploading to college web server




?>