<?php
include "connection.php";
include "auth_check.php";
$id = intval($_GET['id'] ?? 0);
if ($id) {
    // optionally delete cover file - skipped for simplicity
    $stmt = mysqli_prepare($link, "DELETE FROM books WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
header("Location: home.php");
exit();
