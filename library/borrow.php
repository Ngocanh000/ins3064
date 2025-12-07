<?php
session_start();
include "connection.php";

if (!isset($_SESSION["user_id"])) exit();

$uid = $_SESSION["user_id"];
$id = $_GET["id"];

// check quantity
$b = mysqli_fetch_assoc(mysqli_query($link, "SELECT quantity FROM books WHERE id=$id"));
if ($b["quantity"] <= 0) die("Hết sách!");

mysqli_query($link,
    "INSERT INTO loans (user_id, book_id, quantity) VALUES ($uid,$id,1)"
);

mysqli_query($link,
    "UPDATE books SET quantity=quantity-1 WHERE id=$id"
);

header("Location: home.php");
?>
