<?php
session_start();
include "connection.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$book_id = intval($_GET["id"]);

// Check số lượng
$b = mysqli_fetch_assoc(mysqli_query($link,
    "SELECT quantity FROM books WHERE id=$book_id"
));

if ($b["quantity"] <= 0) {
    die("Hết sách!");
}

// Insert loan
mysqli_query($link,"
    INSERT INTO loans(user_id, book_id, status)
    VALUES ($user_id, $book_id, 'borrowed')
");

// Trừ SL
mysqli_query($link,"
    UPDATE books SET quantity = quantity - 1 WHERE id=$book_id
");

header("Location: loans.php");
?>
