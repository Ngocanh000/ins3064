<?php
session_start();
include "connection.php";

$id = $_GET["id"];
$loan = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM loans WHERE id=$id"));

mysqli_query($link,"
UPDATE loans SET status='returned', returned_at=NOW() WHERE id=$id
");

mysqli_query($link,"
UPDATE books SET quantity=quantity+1 WHERE id={$loan['book_id']}
");

if (strtotime($loan["returned_at"]) > strtotime($loan["due_date"])) {
    mysqli_query($link,"
    UPDATE users SET late_count = late_count+1 WHERE id={$loan['user_id']}
    ");

    mysqli_query($link,"
    UPDATE users SET blocked=1 WHERE late_count>=3
    ");
}

header("Location: loans.php");
