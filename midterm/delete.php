<?php
include "connection.php";
$id = $_GET['id'];
mysqli_query($link, "DELETE FROM books WHERE id=$id");
header("Location: home.php");
exit();
?>
