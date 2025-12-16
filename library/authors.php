<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
/* ====== THÊM TÁC GIẢ ====== */
if (isset($_POST['add'])) {
    $name = trim(mysqli_real_escape_string($link, $_POST['name']));
    if ($name !== '') {
        mysqli_query($link, "INSERT IGNORE INTO authors(name) VALUES('$name')");
    }
    header("Location: authors.php");
    exit;
}
/* ====== SỬA TÁC GIẢ ====== */
if (isset($_POST['edit'])) {
    $id   = intval($_POST['id']);
    $name = trim(mysqli_real_escape_string($link, $_POST['name']));
    if ($name !== '') {
        mysqli_query($link, "UPDATE authors SET name='$name' WHERE id=$id");
    }
    header("Location: authors.php");
    exit;
}
/* ====== XOÁ TÁC GIẢ (nếu chưa có sách) ====== */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $check = mysqli_query($link, "SELECT COUNT(*) AS total FROM books WHERE author_id=$id");
    $row = mysqli_fetch_assoc($check);

    if ($row['total'] == 0) {
        mysqli_query($link, "DELETE FROM authors WHERE id=$id");
    }

    header("Location: authors.php");
    exit;
}

$authors = mysqli_query($link, "SELECT * FROM authors ORDER BY name");
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
<h2>✍ Quản lý tác giả</h2>
<a href="home.php">⬅ Quay lại</a>

<h3>➕ Thêm tác giả</h3>
<form method="post">
    <input name="name" placeholder="Tên tác giả" required>
    <button name="add">Thêm</button>
</form>

<h3>📋 Danh sách tác giả</h3>
<table class="books">
<tr>
    <th>ID</th>
    <th>Tên</th>
    <th>Hành động</th>
</tr>

<?php while ($a = mysqli_fetch_assoc($authors)): ?>
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
           href="authors.php?delete=<?= $a['id'] ?>"
           onclick="return confirm('Xoá tác giả này?')">🗑 Xoá</a>
    </td>
</tr>
<?php endwhile; ?>

</table>
</div>

</body>
</html>
