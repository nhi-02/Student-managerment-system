<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'hn_marathondb';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
