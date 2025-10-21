<?php
include("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($link, "DELETE FROM laptops WHERE id=$id");
}

header("Location: index.php");
exit();
?>

