<?php
// book_edit.php
include "connection.php";
include "auth_check.php";
$id = intval($_GET['id'] ?? 0);
if (!$id) { header("Location: home.php"); exit(); }

// fetch book
$stmt = mysqli_prepare($link, "SELECT * FROM books WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$book = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);
if (!$book) { header("Location: home.php"); exit(); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $title = trim($_POST['title']);
    $author_id = !empty($_POST['author_id']) ? intval($_POST['author_id']) : null;
    $new_author = trim($_POST['new_author']);
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $new_category = trim($_POST['new_category']);
    $year = intval($_POST['year']);
    $quantity = intval($_POST['quantity']);
    $book_link = trim($_POST['book_link']);
    $description = trim($_POST['description']);

    if ($new_author !== "") {
        $stmt = mysqli_prepare($link, "INSERT INTO authors (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $new_author);
        mysqli_stmt_execute($stmt);
        $author_id = mysqli_insert_id($link);
        mysqli_stmt_close($stmt);
    }
    if ($new_category !== "") {
        $stmt = mysqli_prepare($link, "INSERT INTO categories (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $new_category);
        mysqli_stmt_execute($stmt);
        $category_id = mysqli_insert_id($link);
        mysqli_stmt_close($stmt);
    }

    $cover_path = $book['cover_image'];

    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (!in_array(strtolower($ext), $allowed)) {
            $errors[] = "Unsupported image type.";
        } else {
            $fn = time()."_".preg_replace('/[^a-z0-9\-_\.]/i','',$_FILES['cover']['name']);
            $target = "uploads/".$fn;
            if (move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
                $cover_path = $target;
            }
        }
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($link, "UPDATE books SET title=?, author_id=?, category_id=?, year=?, quantity=?, link=?, description=?, cover_image=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "siiiisssi", $title, $author_id, $category_id, $year, $quantity, $book_link, $description, $cover_path, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: home.php");
        exit();
    }
}

// fetch authors & categories
$authors = mysqli_query($link, "SELECT id,name FROM authors ORDER BY name");
$categories = mysqli_query($link, "SELECT id,name FROM categories ORDER BY name");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit Book</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small card centered">
  <h2>Edit Book</h2>
  <?php if(!empty($errors)) foreach($errors as $e) echo "<p class='err'>$e</p>"; ?>
  <form method="post" enctype="multipart/form-data">
    <input name="title" value="<?=htmlspecialchars($book['title'])?>" required>
    <div class="inline">
      <select name="author_id">
        <option value="">-- Select author --</option>
        <?php while($a=mysqli_fetch_assoc($authors)): ?>
          <option value="<?=$a['id']?>" <?=($a['id']==$book['author_id'])?'selected':'';?>><?=htmlspecialchars($a['name'])?></option>
        <?php endwhile; ?>
      </select>
      <input name="new_author" placeholder="Or add new author">
    </div>
    <div class="inline">
      <select name="category_id">
        <option value="">-- Select category --</option>
        <?php while($c=mysqli_fetch_assoc($categories)): ?>
          <option value="<?=$c['id']?>" <?=($c['id']==$book['category_id'])?'selected':'';?>><?=htmlspecialchars($c['name'])?></option>
        <?php endwhile; ?>
      </select>
      <input name="new_category" placeholder="Or add new category">
    </div>
    <div class="inline">
      <input name="year" type="number" value="<?=htmlspecialchars($book['year'])?>">
      <input name="quantity" type="number" value="<?=htmlspecialchars($book['quantity'])?>">
    </div>
    <input name="book_link" value="<?=htmlspecialchars($book['link'])?>">
    <textarea name="description"><?=htmlspecialchars($book['description'])?></textarea>
    <label>Cover (current):</label>
    <img src="<?=htmlspecialchars($book['cover_image']?:'uploads/default.png')?>" width="80" height="100" onerror="this.src='uploads/default.png'">
    <input type="file" name="cover">
    <button name="save" type="submit" class="btn-primary">Save</button>
    <a href="home.php" class="btn">Back</a>
  </form>
</div>
</body>
</html>
