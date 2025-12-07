<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$loan_id = $_GET['id'];
$uid = $_SESSION['user_id'];

// Lấy thông tin loan
$loan = mysqli_fetch_assoc(mysqli_query($link, "
    SELECT * FROM loans 
    WHERE id = $loan_id AND user_id = $uid
"));

if (!$loan) {
    die("Không tìm thấy thông tin mượn!");
}

$book_id = $loan['book_id'];

// 1. Cập nhật trạng thái trả sách
mysqli_query($link, "
    UPDATE loans 
    SET status='returned', returned_at=NOW() 
    WHERE id=$loan_id
");

// 2. Tăng số lượng sách
mysqli_query($link, "
    UPDATE books 
    SET quantity = quantity + 1 
    WHERE id = $book_id
");

header("Location: loans.php");
exit();
?>
