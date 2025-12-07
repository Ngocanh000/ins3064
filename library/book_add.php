<?php
session_start();
include "connection.php";

if ($_SESSION["role"] != "admin") {
    header("Location: home.php");
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = mysqli_real_escape_string($link, $_POST["title"]);
    $author = mysqli_real_escape_string($link, $_POST["author"]);
    $category = mysqli_real_escape_string($link, $_POST["category"]);
    $year = $_POST["year"];
    $quantity = $_POST["quantity"];
    $description = mysqli_real_escape_string($link, $_POST["description"]);

    // handle image
    $img = "uploads/default.png";

    if (!empty($_FILES['cover']['name'])) {
        $img = "uploads/" . time() . "_" . $_FILES['cover']['name'];
        move_uploaded_file($_FILES['cover']['tmp_name'], $img);
    }

    // insert author
    mysqli_query($link, "INSERT INTO authors (name) VALUES ('$author')");
    $aid = mysqli_insert_id($link);

    // insert category
    mysqli_query($link, "INSERT INTO categories (name) VALUES ('$category')");
    $cid = mysqli_insert_id($link);

    // insert book
    mysqli_query($link,
        "INSERT INTO books (title,author_id,category_id,year,quantity,description,cover_image)
        VALUES ('$title',$aid,$cid,$year,$quantity,'$description','$img')"
    );

    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><link rel="stylesheet" href="style.css"><title>Add Book</title></head>
<body>
<div class="container small">
<h2>Thêm sách</h2>

<form method="post" enctype="multipart/form-data">
    <input name="title" placeholder="Tên sách" required>
    <input name="author" placeholder="Tác giả" required>
    <input name="category" placeholder="Thể loại" required>
    <input name="year" type="number" placeholder="Năm">
    <input name="quantity" type="number" placeholder="Số lượng">
    <textarea name="description" placeholder="Mô tả"></textarea>
    <input type="file" name="cover">
    <button type="submit">Lưu</button>
</form>

</div>
</body>
</html>
