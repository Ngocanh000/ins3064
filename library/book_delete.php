<?php
session_start();
include "connection.php";

if ($_SESSION["role"] != "admin") exit();

$id = intval($_GET["id"]);
mysqli_query($link, "DELETE FROM books WHERE id=$id");

header("Location: home.php");
?>
