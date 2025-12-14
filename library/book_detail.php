<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;

$stmt = mysqli_prepare($link, "
SELECT b.*, a.name AS author, c.name AS category
FROM books b
LEFT JOIN authors a ON b.author_id=a.id
LEFT JOIN categories c ON b.category_id=c.id
WHERE b.id=?
");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$book = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$book) die("Không tìm thấy sách");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?= $book['title'] ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container detail">
 <img src="<?= $row['cover_image'] ?: 'uploads/default.png' ?>" 
                     style="width:70px;border-radius:6px">
<div>
<h2><?= $book['title'] ?></h2>
<p><b>Tác giả:</b> <?= $book['author'] ?></p>
<p><b>Thể loại:</b> <?= $book['category'] ?></p>
<p><b>Năm:</b> <?= $book['publish_year'] ?></p>

<p class="desc"><?= nl2br($book['description']) ?></p>

<?php if ($book['quantity'] > 0): ?>
<a class="btn" href="borrow.php?id=<?= $book['id'] ?>">📥 Mượn sách</a>
<?php else: ?>
<span class="out">Hết sách</span>
<?php endif; ?>
</div>
</div>
</body>
</html>
