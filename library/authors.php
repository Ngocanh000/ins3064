<?php
session_start();
include "connection.php";

if ($_SESSION['role'] != 'admin') {
    die("Bạn không có quyền truy cập!");
}

if (isset($_POST["add"])) {
    $name = trim($_POST["name"]);
    mysqli_query($link, "INSERT INTO authors(name) VALUES('$name')");
}

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    mysqli_query($link, "DELETE FROM authors WHERE id=$id");
}

$authors = mysqli_query($link, "SELECT * FROM authors ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản lý tác giả</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Danh sách tác giả</h2>

<div class="form-container">
    <form method="POST">
        <input type="text" name="name" placeholder="Tên tác giả" required>
        <button name="add">Thêm</button>
    </form>
</div>

<table class="table">
    <tr>
        <th>ID</th>
        <th>Tên tác giả</th>
        <th>Xóa</th>
    </tr>

    <?php while ($a = mysqli_fetch_assoc($authors)) { ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= $a['name'] ?></td>
            <td><a class="delete" href="?delete=<?= $a['id'] ?>">X</a></td>
        </tr>
    <?php } ?>
</table>

<a href="home.php" class="back">⟵ Quay lại</a>

</body>
</html>
