<?php
session_start();
include "connection.php";

if ($_SESSION["role"] !== "admin") {
    header("Location: home.php");
    exit();
}

$cats = mysqli_query($link, "SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Categories</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Danh sách thể loại</h2>

<table class="books">
<tr><th>ID</th><th>Tên</th></tr>
<?php while ($c = mysqli_fetch_assoc($cats)): ?>
<tr>
    <td><?= $c["id"] ?></td>
    <td><?= $c["name"] ?></td>
</tr>
<?php endwhile; ?>
</table>

<a href="home.php">⬅ Trở lại</a>
</div>
</body>
</html>
