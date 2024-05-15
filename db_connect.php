<?php
$servername = "localhost";
$username = "root";
$password = "cs361";
$dbname = "education_technologies_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}