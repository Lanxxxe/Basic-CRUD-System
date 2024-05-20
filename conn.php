<?php

$conn = new mysqli('localhost', 'root', '', 'simpleordersystem');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>