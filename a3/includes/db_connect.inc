<?php
// Check if the server is localhost or production
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    // Local development server settings
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "petsvictoria";
} else {
    // Production server settings
    $servername = "talsprddb02.int.its.rmit.edu.au";
    $username = "s3840980";
    $password = "Jollybird4!";
    $dbname = "s3840980";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
