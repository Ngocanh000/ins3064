<?php
session_start();
include "connection.php";

if ($_SESSION['role'] != 'admin') {
    die("Bạn không có quyền truy cập!");
}

if (isset($_POST["add"])) {
    $name = trim($_POST["name"]);
    mysqli_query($link, "INSERT INTO categories(name) VALUES('$name')");
}

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    mysqli_query($link, "DELETE FROM categories WHERE id=$id");
}

$categories = mysqli_query($link, "SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản lý thể loại</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Danh sách thể loại</h2>

<div class="form-container">
    <form method="POST">
        <input type="text" name="name" placeholder="Tên thể loại" required>
        <button name="add">Thêm</button>
    </form>
</div>

<table class="table">
    <tr>
        <th>ID</th>
        <th>Thể loại</th>
        <th>Xóa</th>
    </tr>

    <?php while ($c = mysqli_fetch_assoc($categories)) { ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['name'] ?></td>
            <td><a class="delete" href="?delete=<?= $c['id'] ?>">X</a></td>
        </tr>
    <?php } ?>
</table>

<a href="home.php" class="back">⟵ Quay lại</a>

</body>
</html>
