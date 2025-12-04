<?php
require "auth_check.php";
require "db.php";

$id = $_GET["id"];
mysqli_query($conn, "DELETE FROM books WHERE id=$id");

header("Location: books.php");
?>
