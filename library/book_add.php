<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$msg = "";

$authors = mysqli_query($link, "SELECT * FROM authors ORDER BY name");
$categories = mysqli_query($link, "SELECT * FROM categories ORDER BY name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $author_id = intval($_POST['author_id']);
    $category_id = intval($_POST['category_id']);
    $year = intval($_POST['year']);
    $quantity = intval($_POST['quantity']);
    $cover = mysqli_real_escape_string($link, $_POST['cover_image']);
    $link_book = mysqli_real_escape_string($link, $_POST['link']);
    $description = mysqli_real_escape_string($link, $_POST['description']);

    $sql = "
        INSERT INTO books
        (title, author_id, category_id, year, quantity, cover_image, link, description)
        VALUES
        ('$title', $author_id, $category_id, $year, $quantity,
         '$cover', '$link_book', '$description')
    ";

    if (mysqli_query($link, $sql)) {
        header("Location: home.php");
        exit;
    } else {
        $msg = mysqli_error($link);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thêm sách</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container small">
    <h2>➕ Thêm sách mới</h2>

    <?php if ($msg): ?>
        <p class="error"><?= $msg ?></p>
    <?php endif; ?>

    <form method="post">

        <input type="text" name="title" placeholder="Tên sách" required>

        <select name="author_id" required>
            <option value="">-- Chọn tác giả --</option>
            <?php while ($a = mysqli_fetch_assoc($authors)): ?>
                <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
            <?php endwhile; ?>
        </select>

        <select name="category_id" required>
            <option value="">-- Chọn thể loại --</option>
            <?php while ($c = mysqli_fetch_assoc($categories)): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endwhile; ?>
        </select>

        <input type="number" name="year" placeholder="Năm xuất bản" required>

        <input type="number" name="quantity" placeholder="Số lượng" min="1" required>

        <input type="text" name="cover_image" placeholder="Link ảnh bìa (https://...)">

        <input type="text" name="link" placeholder="Link sách (PDF / web)">

        <textarea name="description" rows="5" placeholder="Mô tả sách"></textarea>

        <button type="submit">💾 Lưu sách</button>
        <a href="home.php">⬅ Quay lại</a>
    </form>
</div>

</body>
</html>
