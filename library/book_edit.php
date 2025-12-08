<?php
session_start();
include "connection.php";

if ($_SESSION["role"] != "admin") {
    header("Location: home.php");
    exit();
}

if (!isset($_GET["id"])) {
    die("Thiếu ID sách!");
}

$id = intval($_GET["id"]);

// Lấy dữ liệu sách
$book = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM books WHERE id=$id"));
if (!$book) die("Không tìm thấy sách!");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<title>Sửa sách</title>
</head>

<body>
<div class="container small">

<h2>✏ Sửa thông tin sách</h2>

<?php
// Nếu nhấn Lưu
if (isset($_POST["save"])) {

    $title = mysqli_real_escape_string($link, $_POST["title"]);
    $year = intval($_POST["year"]);
    $quantity = intval($_POST["quantity"]);
    $linkBook = mysqli_real_escape_string($link, $_POST["link"]);
    $description = mysqli_real_escape_string($link, $_POST["description"]);

    // Ảnh mới (nếu có)
    $img = $book["cover_image"];
    if (!empty($_FILES["cover"]["name"])) {
        $img = "uploads/" . time() . "_" . $_FILES["cover"]["name"];
        move_uploaded_file($_FILES["cover"]["tmp_name"], $img);
    }

    // Cập nhật
    $sql = "
        UPDATE books SET
            title = '$title',
            year = $year,
            quantity = $quantity,
            link = '$linkBook',
            description = '$description',
            cover_image = '$img'
        WHERE id = $id
    ";

    if (mysqli_query($link, $sql)) {
        echo "<p style='color:green;'>✔ Cập nhật thành công!</p>";
        // Reload thông tin
        $book = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM books WHERE id=$id"));
    } else {
        echo "<p style='color:red;'>Lỗi SQL: " . mysqli_error($link) . "</p>";
    }
}
?>

<form method="post" enctype="multipart/form-data">

    <label>Tiêu đề:</label>
    <input name="title" value="<?= $book['title'] ?>" required>

    <label>Năm:</label>
    <input name="year" type="number" value="<?= $book['year'] ?>">

    <label>Số lượng:</label>
    <input name="quantity" type="number" value="<?= $book['quantity'] ?>">

    <label>Link đọc sách (PDF/Web):</label>
    <input name="link" value="<?= $book['link'] ?>">

    <label>Mô tả:</label>
    <textarea name="description"><?= $book['description'] ?></textarea>

    <label>Ảnh bìa hiện tại:</label><br>
    <img src="<?= $book['cover_image'] ?>" width="120"><br><br>

    <label>Chọn ảnh mới (nếu muốn thay):</label>
    <input type="file" name="cover">

    <button name="save">Lưu thay đổi</button>
</form>

<br>
<a href="home.php">⬅ Quay lại</a>

</div>
</body>
</html>
