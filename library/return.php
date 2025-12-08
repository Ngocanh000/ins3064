<?php
session_start();
include "connection.php";

$loan_id = intval($_GET["id"]);
$loan = mysqli_fetch_assoc(mysqli_query($link,
    "SELECT * FROM loans WHERE id=$loan_id"
));

if (!$loan) die("Lỗi: Không có khoản mượn này!");

$book_id = $loan["book_id"];

// update status
mysqli_query($link,"
    UPDATE loans SET status='returned', returned_at=NOW()
    WHERE id=$loan_id
");

// restore quantity
mysqli_query($link,"
    UPDATE books SET quantity = quantity + 1 WHERE id=$book_id
");

header("Location: loans.php");
?>
