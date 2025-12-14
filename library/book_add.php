<?php
session_start();
include "connection.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$uid  = $_SESSION['user_id'];
$role = $_SESSION['role']; // admin | user
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
    die("Access denied");
}

$msg = "";

if (isset($_POST["add"])) {
    $title = $_POST["title"];
    $author_id = $_POST["author_id"];
    $category_id = $_POST["category_id"];
    $year = $_POST["year"];
    $quantity = $_POST["quantity"];
    $description = $_POST["description"];
    $link = $_POST["link"];

    $cover = "uploads/default.png";
    if (!empty($_FILES["cover"]["name"])) {
        $cover = "uploads/default.png" . time() . "_" . $_FILES["cover"]["name"];
        move_uploaded_file($_FILES["cover"]["tmp_name"], $cover);
    }

    mysqli_query($link, "
        INSERT INTO books(title, author_id, category_id, year, quantity, description, cover_image, link)
        VALUES('$title',$author_id,$category_id,'$year',$quantity,'$description','$cover','$link')
    ");

    $msg = "Thêm sách thành công!";
}

$authors = mysqli_query($link, "SELECT * FROM authors");
$categories = mysqli_query($link, "SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><link rel="stylesheet" href="style.css"></head>
<body>
<h2>Thêm sách</h2>
<p><?= $msg ?></p>

<form method="post" enctype="multipart/form-data">
<input name="title" placeholder="Tên sách" required>

<select name="author_id" required>
<option value="">-- Tác giả --</option>
<?php while($a=mysqli_fetch_assoc($authors)) echo "<option value='{$a['id']}'>{$a['name']}</option>"; ?>
</select>

<select name="category_id" required>
<option value="">-- Thể loại --</option>
<?php while($c=mysqli_fetch_assoc($categories)) echo "<option value='{$c['id']}'>{$c['name']}</option>"; ?>
</select>

<input name="year" placeholder="Năm xuất bản">
<input name="quantity" type="number" placeholder="Số lượng" required>
<textarea name="description" placeholder="Mô tả"></textarea>
<input name="link" placeholder="Link PDF / online">
<input type="file" name="cover">
<button name="add">Thêm</button>
</form>
</body>
</html>
