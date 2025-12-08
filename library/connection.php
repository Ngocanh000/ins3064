<?php
date_default_timezone_set('Asia/Ho_Chi_Minh'); // GIỜ VIỆT NAM

$DB_HOST = "sql100.infinityfree.com";
$DB_USER = "if0_40585566";
$DB_PASS = "Ngocanh000";
$DB_NAME = "if0_40585566_library";

$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$link) {
    die("Database connection error: " . mysqli_connect_error());
}

mysqli_set_charset($link, 'utf8mb4');

// Set timezone cho MySQL luôn
mysqli_query($link, "SET time_zone = '+07:00'");
?>
