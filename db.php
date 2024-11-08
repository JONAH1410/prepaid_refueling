<?php
$servername = "localhost";
$username = "root";
$password = "Ja@deni14109021";
$dbname = "refuel_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>