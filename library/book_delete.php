<?php
session_start();
include "connection.php";
if ($_SESSION["role"] != "admin") die("Access denied");

$id = $_GET["id"];

$check = mysqli_query($link,
    "SELECT * FROM loans WHERE book_id=$id AND status='borrowed'"
);

if (mysqli_num_rows($check) > 0) {
    die("Sách đang được mượn, không thể xoá");
}

mysqli_query($link, "DELETE FROM books WHERE id=$id");
header("Location: home.php");
