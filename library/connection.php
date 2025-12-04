<?php
$host = "sql100.byetcluster.com";
$username = "if0_40585566";
$password = "MẬT_KHẨU_MYSQL_CỦA_EM";
$database = "if0_40585566_library";

$link = mysqli_connect($host, $username, $password, $database);

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
