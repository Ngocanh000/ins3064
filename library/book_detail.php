<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];
$id   = intval($_GET['id'] ?? 0);
if ($id <= 0) die("Invalid book");

$q = mysqli_query($link, "
    SELECT b.*, a.name AS author, c.name AS category
    FROM books b
    LEFT JOIN authors a ON b.author_id = a.id
    LEFT JOIN categories c ON b.category_id = c.id
    WHERE b.id = $id
");

$book = mysqli_fetch_assoc($q);
if (!$book) die("Book not found");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Chi tiết sách</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page">
<div class="container small">

<h2>📖 <?= htmlspecialchars($book['title']) ?></h2>

<div class="book-detail">

    <img src="<?= htmlspecialchars($book['cover_image'] ?: 'uploads/default.png') ?>" width="120">

    <div class="book-info">
        <p><b>Tác giả:</b> <?= htmlspecialchars($book['author']) ?></p>
        <p><b>Thể loại:</b> <?= htmlspecialchars($book['category']) ?></p>
        <p><b>Năm:</b> <?= $book['year'] ?></p>

        <p><b>Mô tả:</b></p>
        <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>

        <!-- ADMIN -->
        <?php if ($role === 'admin'): ?>
            <?php if (!empty($book['link'])): ?>
                <a class="btn view" target="_blank"
                   href="<?= htmlspecialchars($book['link']) ?>">
                   📄 Xem link sách
                </a>
            <?php endif; ?>

        <!-- USER -->
        <?php else: ?>
            <?php if ($book['quantity'] > 0): ?>
                <a class="btn borrow" href="borrow.php?id=<?= $book['id'] ?>">
                    📥 Mượn sách
                </a>
            <?php else: ?>
                <span class="out">❌ Hết sách</span>
            <?php endif; ?>
        <?php endif; ?>

        <br><br>
        <a href="home.php">⬅ Quay lại</a>
    </div>

</div>
</div>
</div>

</body>
</html>
