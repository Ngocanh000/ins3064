<?php
session_start();
include "connection.php";

/* ===== PHÂN QUYỀN ===== */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) die("Invalid ID");

/* ===== LẤY SÁCH ===== */
$book = mysqli_fetch_assoc(mysqli_query($link,
    "SELECT * FROM books WHERE id = $id"
));
if (!$book) die("Book not found");

/* ===== LẤY AUTHORS + CATEGORIES ===== */
$authors = mysqli_query($link, "SELECT id, name FROM authors ORDER BY name");
$categories = mysqli_query($link, "SELECT id, name FROM categories ORDER BY name");

/* ===== KHI BẤM SAVE ===== */
if (isset($_POST['save'])) {

    $title       = mysqli_real_escape_string($link, $_POST['title']);
    $author_id   = intval($_POST['author_id']);
    $category_id = intval($_POST['category_id']);
    $year        = intval($_POST['year']);
    $quantity    = intval($_POST['quantity']);
    $link_book   = mysqli_real_escape_string($link, $_POST['link']);
    $description = mysqli_real_escape_string($link, $_POST['description']);

    // mặc định giữ ảnh cũ
    $cover_image = $book['cover_image'];

    // nếu upload ảnh mới
    if (!empty($_FILES['cover']['name'])) {
        $fileName = time() . "_" . basename($_FILES['cover']['name']);
        $target   = "uploads/" . $fileName;

        if (move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
            $cover_image = $target;
        }
    }

    $sql = "
        UPDATE books SET
            title = '$title',
            author_id = $author_id,
            category_id = $category_id,
            year = $year,
            quantity = $quantity,
            description = '$description',
            link = '$link_book',
            cover_image = '$cover_image'
        WHERE id = $id
    ";

    if (!mysqli_query($link, $sql)) {
        die("Update failed: " . mysqli_error($link));
    }

    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Book</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page">
<div class="container small">
<h2>✏ Edit Book</h2>

<form method="post" enctype="multipart/form-data">

    <label>Title</label>
    <input name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

    <label>Author</label>
    <select name="author_id" required>
        <?php while ($a = mysqli_fetch_assoc($authors)): ?>
            <option value="<?= $a['id'] ?>"
                <?= $a['id'] == $book['author_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($a['name']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Category</label>
    <select name="category_id" required>
        <?php while ($c = mysqli_fetch_assoc($categories)): ?>
            <option value="<?= $c['id'] ?>"
                <?= $c['id'] == $book['category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['name']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Year</label>
    <input type="number" name="year" value="<?= $book['year'] ?>">

    <label>Quantity</label>
    <input type="number" name="quantity" value="<?= $book['quantity'] ?>">

    <label>Book link (PDF / Online)</label>
    <input name="link" value="<?= htmlspecialchars($book['link']) ?>">

    <label>Description</label>
    <textarea name="description"><?= htmlspecialchars($book['description']) ?></textarea>

    <label>Current Cover</label><br>
    <img src="<?= $book['cover_image'] ?>" width="120"><br><br>

    <label>Change Cover</label>
    <input type="file" name="cover">

    <br><br>
    <button class="btn" name="save">💾 Save Changes</button>
    <a href="home.php" class="btn">Cancel</a>

</form>
</div>
</div>

</body>
</html>
