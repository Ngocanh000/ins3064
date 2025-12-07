<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['username'])) { header('Location: login.php'); exit(); }
$uid = $_SESSION['user_id'];
$loan_id = intval($_GET['loan_id'] ?? 0);
if ($loan_id>0) {
    $loan = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM loans WHERE id=$loan_id AND user_id=$uid"));
    if ($loan && $loan['status']=='borrowed') {
        mysqli_query($link,"UPDATE loans SET status='returned', returned_at=NOW() WHERE id=$loan_id");
        mysqli_query($link,"UPDATE books SET quantity = quantity + ". intval($loan['quantity']) ." WHERE id=". intval($loan['book_id']));
    }
}
header('Location: home.php'); exit();
