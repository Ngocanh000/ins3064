<?php
session_start();
include "connection.php";

if ($_SESSION["role"] !== "admin") {
    header("Location: home.php");
    exit();
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $category = $_POST["category"];
    $year = $_POST["year"];
    $qty = $_POST["quantity"];
    $desc = $_POST["description"];
    $link_book = $_POST["link"];

    // Tìm hoặc tạo tác giả
    $q = mysqli_query($link, "SELECT id FROM authors WHERE name='$author'");
    if (mysqli_num_rows($q)) $aid = mysqli_fetch_assoc($q)['id'];
    else {
        mysqli_query($link, "INSERT INTO authors(name) VALUES('$author')");
        $aid = mysqli_insert_id($link);
    }

    // Tìm hoặc tạo thể loại
    $q = mysqli_query($link, "SELECT id FROM categories WHERE name='$category'");
    if (mysqli_num_rows($q)) $cid = mysqli_fetch_assoc($q)['id'];
    else {
        mysqli_query($link, "INSERT INTO categories(name) VALUES('$category')");
        $cid = mysqli_insert_id($link);
    }

    // Upload ảnh
    $cover = "uploads/default.png";
    if (!empty($_FILES["cover"]["name"])) {
        $name = time() . "_" . $_FILES["cover"]["name"];
        move_uploaded_file($_FILES["cover"]["tmp_name"], "uploads/" . $name);
        $cover = "uploads/" . $name;
    }

    mysqli_query($link,
        "INSERT INTO books(title, author_id, category_id, year, quantity, description, cover_image, link)
         VALUES('$title',$aid,$cid,$year,$qty,'$desc','$cover','$link_book')"
    );

    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Add Book</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small">
    <h2>Thêm sách</h2>

    <form method="POST" enctype="multipart/form-data">
        <input name="title" placeholder="Tên sách" required>
        <input name="author" placeholder="Tác giả" required>
        <input name="category" placeholder="Thể loại" required>
        <input type="number" name="year" placeholder="Năm xuất bản">
        <input type="number" name="quantity" placeholder="Số lượng">
        <textarea name="description" placeholder="Mô tả"></textarea>
        <input name="link" placeholder="Link đọc online">
        <input type="file" name="cover">
        <button type="submit">Thêm</button>
    </form>

    <a href="home.php">⬅ Quay lại</a>
</div>
</body>
</html>
