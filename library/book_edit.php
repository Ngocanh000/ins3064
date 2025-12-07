<?php
// book_edit.php
session_start();
include 'connection.php';
if (!isset($_SESSION['username']) || $_SESSION['role']!=='admin') { header('Location: login.php'); exit(); }
$id = intval($_GET['id'] ?? 0);
if ($id<=0) { header('Location: home.php'); exit(); }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $title = mysqli_real_escape_string($link,$_POST['title']);
    $author = mysqli_real_escape_string($link,$_POST['author']);
    $category = mysqli_real_escape_string($link,$_POST['category']);
    $year = intval($_POST['year']);
    $quantity = intval($_POST['quantity']);
    $desc = mysqli_real_escape_string($link,$_POST['description']);
    $link_book = mysqli_real_escape_string($link,$_POST['link']);
    // author/category upsert
    $r = mysqli_query($link,"SELECT id FROM authors WHERE name='$author' LIMIT 1");
    if (mysqli_num_rows($r)) $aid = mysqli_fetch_assoc($r)['id']; else { mysqli_query($link,"INSERT INTO authors (name) VALUES ('$author')"); $aid = mysqli_insert_id($link); }
    $r = mysqli_query($link,"SELECT id FROM categories WHERE name='$category' LIMIT 1");
    if (mysqli_num_rows($r)) $cid = mysqli_fetch_assoc($r)['id']; else { mysqli_query($link,"INSERT INTO categories (name) VALUES ('$category')"); $cid = mysqli_insert_id($link); }
    // cover
    $cover = '';
    if (!empty($_FILES['cover']['name']) && $_FILES['cover']['error']===0) {
        $fn = time() . "_" . basename($_FILES['cover']['name']);
        $target='uploads/'.$fn; move_uploaded_file($_FILES['cover']['tmp_name'],$target); $cover=$target;
        mysqli_query($link,"UPDATE books SET cover_image='$cover' WHERE id=$id");
    }
    mysqli_query($link,"UPDATE books SET title='$title', author_id=$aid, category_id=$cid, year=$year, quantity=$quantity, description='$desc', link='$link_book' WHERE id=$id");
    header('Location: home.php'); exit();
}
$res = mysqli_query($link,"SELECT b.*, a.name AS author_name, c.name AS category_name FROM books b LEFT JOIN authors a ON b.author_id=a.id LEFT JOIN categories c ON b.category_id=c.id WHERE b.id=$id");
$row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html><html lang="vi"><head><meta charset="utf-8"><title>Edit</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container small">
  <h3>Edit book</h3>
  <form method="post" enctype="multipart/form-data">
    <input name="title" value="<?= htmlspecialchars($row['title']) ?>" required><br>
    <input name="author" value="<?= htmlspecialchars($row['author_name']) ?>" required><br>
    <input name="category" value="<?= htmlspecialchars($row['category_name']) ?>" required><br>
    <input type="number" name="year" value="<?= htmlspecialchars($row['year']) ?>"><br>
    <input type="number" name="quantity" value="<?= htmlspecialchars($row['quantity']) ?>" required><br>
    <input name="link" value="<?= htmlspecialchars($row['link']) ?>"><br>
    <textarea name="description"><?= htmlspecialchars($row['description']) ?></textarea><br>
    <label>Cover</label><input type="file" name="cover"><br>
    <button name="update" type="submit">Update</button>
    <a href="home.php">Back</a>
  </form>
</div>
</body></html>
