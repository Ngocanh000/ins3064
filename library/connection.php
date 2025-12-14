<?php
$DB_HOST = "sql100.infinityfree.com";
$DB_USER = "if0_40585566";
$DB_PASS = "Ngocanh000";
$DB_NAME = "if0_40585566_library";

$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$link) die("DB Error");

mysqli_set_charset($link, "utf8mb4");
