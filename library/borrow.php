<?php
session_start();
include "connection.php";

$uid = $_SESSION["user_id"];
$book_id = $_GET["id"];

$user = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id=$uid"));
if ($user["blocked"]) die("Bạn đã bị khóa quyền mượn sách");

$book = mysqli_fetch_assoc(mysqli_query($link, "SELECT quantity FROM books WHERE id=$book_id"));
if ($book["quantity"] <= 0) die("Hết sách");

$days = $user["loan_period_days"];
$due = date("Y-m-d H:i:s", strtotime("+$days days"));

mysqli_query($link,"
INSERT INTO loans(user_id, book_id, due_date)
VALUES($uid,$book_id,'$due')
");

mysqli_query($link,"UPDATE books SET quantity=quantity-1 WHERE id=$book_id");

header("Location: loans.php");
