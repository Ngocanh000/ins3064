<?php
include "connection.php";
include "auth_check.php";
$id = intval($_GET['id'] ?? 0);
if ($id) {
    $stmt = mysqli_prepare($link,"DELETE FROM authors WHERE id=?");
    mysqli_stmt_bind_param($stmt,"i",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
header("Location: authors.php");
exit();
