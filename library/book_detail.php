<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];
$id = intval($_GET['id']);

$q = mysqli_query($link, "
    SELECT b.*, a.name AS author, c.name AS category
    FROM books b
    LEFT JOIN authors a ON b.author_id = a.id
    LEFT JOIN categories c ON b.category_id = c.id
    WHERE b.id = $id
");

$book = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chi tiết sách</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>📖 <?= htmlspecialchars($book['title']) ?></h2>

    <div class="book-detail">
        <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="cover">

        <div class="book-info">
            <p><b>Tác giả:</b> <?= htmlspecialchars($book['author']) ?></p>
            <p><b>Thể loại:</b> <?= htmlspecialchars($book['category']) ?></p>
            <p><b>Năm:</b> <?= $book['year'] ?></p>
            <p><b>Mô tả:</b></p>
                <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
            <?php if ($role === 'admin'): ?>
                <!-- ADMIN: xem link -->
                <a class="btn view" target="_blank"
                   href="<?= htmlspecialchars($book['link']) ?>">
                   📄 Xem link sách
                </a>
            <?php else: ?>
                <!-- USER: xem mô tả -->
                <p><b>Mô tả:</b></p>
                <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
            <?php endif; ?>

            <br>
            <a href="home.php">⬅ Quay lại</a>
        </div>
    </div>
</div>

</body>
</html>
