<?php
$link = mysqli_connect("localhost", "root", "", "library_db");
if (!$link) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
