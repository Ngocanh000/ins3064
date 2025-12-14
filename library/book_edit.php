<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("⛔ Không có quyền");
}

$id = $_GET['id'] ?? 0;

// lấy sách
$stmt = mysqli_prepare($link, "SELECT * FROM books WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$book = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$book) die("Không tìm thấy sách");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $year  = $_POST['publish_year'];
    $qty   = $_POST['quantity'];
    $desc  = $_POST['description'];

    $cover = $book['cover'];
    if (!empty($_FILES['cover']['name'])) {
        $cover = time() . "_" . $_FILES['cover']['name'];
        move_uploaded_file($_FILES['cover']['tmp_name'], "uploads/$cover");
    }

    $sql = "UPDATE books 
            SET title=?, publish_year=?, quantity=?, description=?, cover=?
            WHERE id=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "siissi",
        $title, $year, $qty, $desc, $cover, $id
    );
    mysqli_stmt_execute($stmt);

    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Sửa sách</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>✏ Sửa sách</h2>

<form method="post" enctype="multipart/form-data">
<label>Tên sách</label>
<input name="title" value="<?= $book['title'] ?>">

<label>Năm xuất bản</label>
<input type="number" name="publish_year" value="<?= $book['publish_year'] ?>">

<label>Số lượng</label>
<input type="number" name="quantity" value="<?= $book['quantity'] ?>">

<label>Mô tả</label>
<textarea name="description"><?= $book['description'] ?></textarea>

<label>Ảnh bìa</label>
<input type="file" name="cover">
<img src="uploads/<?= $book['cover'] ?>" height="80">

<button>Lưu</button>
</form>
</div>
</body body>
</html>
