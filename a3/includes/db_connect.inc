<?php

if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {
    $servername = "talsprddb02.int.its.rmit.edu.au";
    $username = "root";
    $password = "";
    $dbname = "petsvictoria";
} else{
    $servername = talsprddb02.int.its.rmit.edu.au";
    $username = "s3840980";
    $password = "Jollybird4!";
    $dbname = "s3840980";
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
