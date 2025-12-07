<?php
session_start();
include "connection.php";
if ($_SESSION["role"] != "admin") { header("Location: home.php"); }

$id = $_GET["id"];
$book = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM books WHERE id=$id"));
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><link rel="stylesheet" href="style.css"><title>Edit Book</title></head>
<body>
<div class="container small">
<h2>Sửa sách</h2>

<form method="post" enctype="multipart/form-data">

    <input name="title" value="<?= $book['title'] ?>" required>
    <input name="year" type="number" value="<?= $book['year'] ?>">
    <input name="quantity" type="number" value="<?= $book['quantity'] ?>">
    <textarea name="description"><?= $book['description'] ?></textarea>
    <input type="file" name="cover">

    <button name="save">Lưu</button>
</form>

</div>
</body>
</html>
