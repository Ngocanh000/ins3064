<?php
include "connection.php";
session_start();

$id = $_GET['id'];
$res = mysqli_query($link, "SELECT * FROM books WHERE id=$id");
$row = mysqli_fetch_assoc($res);

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $year = $_POST['year'];
    $quantity = $_POST['quantity'];
    $linkb = $_POST['link'];
    $description = $_POST['description'];

    $cover_image = $row['cover_image'];
    if (!empty($_FILES['cover_image']['name'])) {
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES["cover_image"]["name"]);
        $target_file = $target_dir . $file_name;
        move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file);
        $cover_image = $target_file;
    }

    mysqli_query($link, "UPDATE books 
                         SET title='$title', author='$author', category='$category', year='$year', 
                             quantity='$quantity', link='$linkb', cover_image='$cover_image', description='$description'
                         WHERE id=$id");
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small">
    <h2>Edit Book</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" value="<?= $row['title'] ?>" required><br>
        <input type="text" name="author" value="<?= $row['author'] ?>" required><br>
        <input type="text" name="category" value="<?= $row['category'] ?>"><br>
        <input type="number" name="year" value="<?= $row['year'] ?>"><br>
        <input type="number" name="quantity" value="<?= $row['quantity'] ?>"><br>
        <input type="url" name="link" value="<?= $row['link'] ?>"><br>
        <textarea name="description"><?= $row['description'] ?></textarea><br>
        <label>Change Cover:</label>
        <input type="file" name="cover_image" accept="image/*"><br>
        <button type="submit" name="update">Update</button>
    </form>
</div>
</body>
</html>
