<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['username'])) { header('Location: login.php'); exit(); }
$uid = $_SESSION['user_id'];
$id = intval($_GET['id'] ?? 0);
if ($id<=0) { header('Location: home.php'); exit(); }
$book = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM books WHERE id=$id"));
if (!$book) { header('Location: home.php'); exit(); }
if ($book['quantity'] <= 0) { die("Book not available."); }
// create loan (quantity 1)
mysqli_query($link, "INSERT INTO loans (user_id, book_id, quantity, status) VALUES ($uid, $id, 1, 'borrowed')");
mysqli_query($link, "UPDATE books SET quantity = quantity - 1 WHERE id=$id");
header('Location: home.php'); exit();
