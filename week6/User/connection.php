<?php
$link = mysqli_connect("localhost", "root", "", "user_management");

if (!$link) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
?>
