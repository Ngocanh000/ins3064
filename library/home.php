<?php
// home.php
session_start();
include 'connection.php';
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); exit();
}
$uid = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? 'user';

// handle add book (admin)
if ($role === 'admin' && isset($_POST['add_book'])) {
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $author = mysqli_real_escape_string($link, $_POST['author']);
    $category = mysqli_real_escape_string($link, $_POST['category']);
    $year = intval($_POST['year']);
    $quantity = intval($_POST['quantity']);
    $link_book = mysqli_real_escape_string($link, $_POST['link']);
    $desc = mysqli_real_escape_string($link, $_POST['description']);
    // up cover
    $cover_path = 'uploads/default.png';
    if (!empty($_FILES['cover']['name']) && $_FILES['cover']['error'] === 0) {
        $fn = time() . "_" . basename($_FILES['cover']['name']);
        $target = 'uploads/' . $fn;
        move_uploaded_file($_FILES['cover']['tmp_name'], $target);
        $cover_path = $target;
    }
    // ensure author/category exist (simple)
    $aid = null; $cid = null;
    $r = mysqli_query($link, "SELECT id FROM authors WHERE name='". $author ."' LIMIT 1");
    if (mysqli_num_rows($r)) { $aid = mysqli_fetch_assoc($r)['id']; }
    else { mysqli_query($link, "INSERT INTO authors (name) VALUES ('".$author."')"); $aid = mysqli_insert_id($link); }
    $r = mysqli_query($link, "SELECT id FROM categories WHERE name='". $category ."' LIMIT 1");
    if (mysqli_num_rows($r)) { $cid = mysqli_fetch_assoc($r)['id']; }
    else { mysqli_query($link, "INSERT INTO categories (name) VALUES ('".$category."')"); $cid = mysqli_insert_id($link); }

    mysqli_query($link, "INSERT INTO books (title, author_id, category_id, year, quantity, link, description, cover_image) VALUES ('$title',$aid,$cid,$year,$quantity,'$link_book','$desc','$cover_path')");
    header('Location: home.php'); exit();
}

// list books (join)
$books = mysqli_query($link, "SELECT b.*, a.name AS author_name, c.name AS category_name FROM books b LEFT JOIN authors a ON b.author_id=a.id LEFT JOIN categories c ON b.category_id=c.id ORDER BY b.created_at DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="utf-8"><title>Library Home</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
  <h2>📚 Library — Welcome <?= htmlspecialchars($_SESSION['username']) ?></h2>
  <p><a href="logout.php">Logout</a></p>

  <?php if ($role === 'admin'): ?>
    <section class="card">
      <h3>Thêm sách mới (Admin)</h3>
      <form method="post" enctype="multipart/form-data">
        <input name="title" placeholder="Title" required>
        <input name="author" placeholder="Author" required>
        <input name="category" placeholder="Category" required>
        <input type="number" name="year" placeholder="Year">
        <input type="number" name="quantity" placeholder="Quantity" value="1">
        <input name="link" placeholder="Link (optional)">
        <textarea name="description" placeholder="Short description"></textarea>
        <label>Cover:</label><input type="file" name="cover">
        <button name="add_book" type="submit">Add Book</button>
      </form>
    </section>
  <?php endif; ?>

  <hr>
  <h3>Danh sách sách</h3>
  <table class="books">
    <tr><th>Cover</th><th>Title</th><th>Author</th><th>Category</th><th>Qty</th><th>Action</th></tr>
    <?php while($row = mysqli_fetch_assoc($books)): ?>
      <tr>
        <td><img src="<?= htmlspecialchars($row['cover_image'] ?: 'uploads/default.png') ?>" width="60" height="80" onerror="this.src='uploads/default.png'"></td>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= htmlspecialchars($row['author_name']) ?></td>
        <td><?= htmlspecialchars($row['category_name']) ?></td>
        <td><?= intval($row['quantity']) ?></td>
        <td>
          <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank">View</a>
          <?php if ($role === 'admin'): ?>
            | <a href="book_edit.php?id=<?= $row['id'] ?>">Edit</a>
            | <a href="book_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
          <?php else: ?>
            <?php if ($row['quantity']>0): ?>
              | <a href="borrow.php?id=<?= $row['id'] ?>">Borrow</a>
            <?php else: ?>
              | <span style="color:#c00">Out</span>
            <?php endif; ?>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
