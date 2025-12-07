<?php
session_start();
include "connection.php";

if ($_SESSION["role"] !== "admin") {
    header("Location: home.php");
    exit();
}

$authors = mysqli_query($link, "SELECT * FROM authors ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Authors</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Danh sách tác giả</h2>

<table class="books">
<tr><th>ID</th><th>Tên</th></tr>
<?php while ($a = mysqli_fetch_assoc($authors)): ?>
<tr>
    <td><?= $a["id"] ?></td>
    <td><?= $a["name"] ?></td>
</tr>
<?php endwhile; ?>
</table>

<a href="home.php">⬅ Trở về</a>
</div>
</body>
</html>
