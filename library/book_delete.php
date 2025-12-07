<?php
session_start();
include "connection.php";

if ($_SESSION["role"] !== "admin") {
    header("Location: home.php");
    exit();
}

$id = intval($_GET["id"]);
mysqli_query($link, "DELETE FROM books WHERE id=$id");

header("Location: home.php");
exit();
?>
