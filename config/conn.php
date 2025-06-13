<?php
$conn = new mysqli("localhost", "root", "", "quranic_school"); // Replace with your DB details
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>