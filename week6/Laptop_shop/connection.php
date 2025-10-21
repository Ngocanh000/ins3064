<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "laptop_shop";

$link = mysqli_connect($host, $user, $pass, $db);

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
