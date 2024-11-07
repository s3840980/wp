<?php
$servername1 = "localhost";
$username1 = "root";
$password1 = "";
$dbname1 = "database1";

$conn1 = new mysqli($servername1, $username1, $password1, $dbname1);

if ($conn1->connect_error) {
    die("Connection to database1 failed: " . $conn1->connect_error);
}

$servername2 = "talsprddbo2.int.rmit.edu.au";
$username2 = "s3840980";
$password2 = "Jollybird4!";
$dbname2 = "s3840980";

$conn2 = new mysqli($servername2, $username2, $password2, $dbname2);

if ($conn2->connect_error) {
    die("Connection to database2 failed: " . $conn2->connect_error);
}
?>
