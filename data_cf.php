<?php
$servername = "localhost";
$username = "castor";
$password = "ka1XXXXXXXXXXXXX";
$dbname = "agenda";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

