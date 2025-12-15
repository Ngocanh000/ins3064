<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* ====== Thêm thể loại ====== */
if (isset($_POST['add'])) {
    $name = trim(mysqli_real_escape_string($link, $_POST['name']));
    if ($name !== '') {
        mysqli_query($link, "INSERT IGNORE INTO categories(name) VALUES('$name')");
    }
    header("Location: categories.php");
    exit;
}

/* ====== SỬA Thể loại ====== */
if (isset($_POST['edit'])) {
    $id   = intval($_POST['id']);
    $name = trim(mysqli_real_escape_string($link, $_POST['name']));
    if ($name !== '') {
        mysqli_query($link, "UPDATE categories SET name='$name' WHERE id=$id");
    }
    header("Location: categories.php");
    exit;
}

/* ====== XOÁ Thể loại (nếu chưa có thể loại) ====== */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $check = mysqli_query($link, "SELECT COUNT(*) AS total FROM books WHERE category_id=$id");
    $row = mysqli_fetch_assoc($check);

    if ($row['total'] == 0) {
        mysqli_query($link, "DELETE FROM categories WHERE id=$id");
    }

    header("Location: categories.php");
    exit;
}

$categories = mysqli_query($link, "SELECT * FROM categories ORDER BY name");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Authors</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>✍ Quản lý thể loại</h2>
<a href="home.php">⬅ Quay lại</a>

<h3>➕ Thêm thể loại</h3>
<form method="post">
    <input name="name" placeholder="Tên thể loại" required>
    <button name="add">Thêm</button>
</form>

<h3>📋 Danh sách thể loai</h3>
<table class="books">
<tr>
    <th>ID</th>
    <th>Tên</th>
    <th>Hành động</th>
</tr>

<?php while ($a = mysqli_fetch_assoc($categories)): ?>
<tr>
    <td><?= $a['id'] ?></td>
    <td>
        <form method="post" style="display:flex;gap:6px">
            <input type="hidden" name="id" value="<?= $a['id'] ?>">
            <input name="name" value="<?= htmlspecialchars($a['name']) ?>" required>
            <button name="edit">💾 Lưu</button>
        </form>
    </td>
    <td>
        <a class="btn delete"
           href="categories.php?delete=<?= $a['id'] ?>"
           onclick="return confirm('Xoá thể loại này?')">🗑 Xoá</a>
    </td>
</tr>
<?php endwhile; ?>

</table>
</div>

</body>
</html>
