<?php
// home.php
include "connection.php";
include "auth_check.php";

$errors = [];
$success = "";

// fetch authors & categories for selects
$authors = mysqli_query($link, "SELECT id, name FROM authors ORDER BY name");
$categories = mysqli_query($link, "SELECT id, name FROM categories ORDER BY name");

// handle add book
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    $title = trim($_POST['title']);
    $author_id = !empty($_POST['author_id']) ? intval($_POST['author_id']) : null;
    $new_author = trim($_POST['new_author']);
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $new_category = trim($_POST['new_category']);
    $year = intval($_POST['year']);
    $quantity = intval($_POST['quantity']);
    $book_link = trim($_POST['book_link']);
    $description = trim($_POST['description']);

    // if new author specified, insert it
    if ($new_author !== "") {
        $stmt = mysqli_prepare($link, "INSERT INTO authors (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $new_author);
        mysqli_stmt_execute($stmt);
        $author_id = mysqli_insert_id($link);
        mysqli_stmt_close($stmt);
    }
    // new category
    if ($new_category !== "") {
        $stmt = mysqli_prepare($link, "INSERT INTO categories (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $new_category);
        mysqli_stmt_execute($stmt);
        $category_id = mysqli_insert_id($link);
        mysqli_stmt_close($stmt);
    }

    // cover upload
    $cover_path = "uploads/default.png";
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (!in_array(strtolower($ext), $allowed)) {
            $errors[] = "Unsupported image type.";
        } else {
            $fn = time() . "_" . preg_replace('/[^a-z0-9\-_\.]/i','', $_FILES['cover']['name']);
            $target = "uploads/" . $fn;
            if (!move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
                $errors[] = "Upload failed.";
            } else {
                $cover_path = $target;
            }
        }
    }

    if ($title === "") $errors[] = "Title required.";
    if (empty($errors)) {
        $stmt = mysqli_prepare($link, "INSERT INTO books (title, author_id, category_id, year, quantity, link, description, cover_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "siiiiiss", $title, $author_id, $category_id, $year, $quantity, $book_link, $description, $cover_path);
        if (mysqli_stmt_execute($stmt)) {
            $success = "Book added.";
            header("Location: home.php");
            exit();
        } else {
            $errors[] = "DB error: " . mysqli_error($link);
        }
        mysqli_stmt_close($stmt);
    }
}

// fetch books with author/category names
$sql = "SELECT b.*, a.name AS author_name, c.name AS category_name
        FROM books b
        LEFT JOIN authors a ON b.author_id = a.id
        LEFT JOIN categories c ON b.category_id = c.id
        ORDER BY b.id DESC";
$books = mysqli_query($link, $sql);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Library Management</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-bg">
  <div class="container card large centered">
    <div class="header">
      <h1>📚 Library Management</h1>
      <div class="meta">Welcome, <strong><?=htmlspecialchars($_SESSION['username'])?></strong> | <a href="logout.php">Logout</a></div>
    </div>

    <div class="split">
      <div class="col form-col">
        <h3>Add Book</h3>
        <?php if(!empty($errors)) foreach($errors as $e) echo "<p class='err'>$e</p>"; ?>
        <?php if($success) echo "<p class='ok'>$success</p>"; ?>
        <form method="post" enctype="multipart/form-data">
          <input name="title" placeholder="Book title" required>
          <div class="inline">
            <select name="author_id">
              <option value="">-- Select author --</option>
              <?php while($a = mysqli_fetch_assoc($authors)): ?>
                <option value="<?=$a['id']?>"><?=htmlspecialchars($a['name'])?></option>
              <?php endwhile; ?>
            </select>
            <input name="new_author" placeholder="Or add new author">
          </div>
          <?php
            // re-fetch authors for next form usage
            mysqli_data_seek($authors, 0);
          ?>
          <div class="inline">
            <select name="category_id">
              <option value="">-- Select category --</option>
              <?php while($c = mysqli_fetch_assoc($categories)): ?>
                <option value="<?=$c['id']?>"><?=htmlspecialchars($c['name'])?></option>
              <?php endwhile; ?>
            </select>
            <input name="new_category" placeholder="Or add new category">
          </div>
          <div class="inline">
            <input name="year" type="number" placeholder="Year">
            <input name="quantity" type="number" placeholder="Quantity" value="1">
          </div>
          <input name="book_link" placeholder="Book link (optional)">
          <textarea name="description" placeholder="Short description..."></textarea>
          <label>Upload Cover:</label>
          <input type="file" name="cover">
          <button name="add_book" type="submit" class="btn-primary">Add Book</button>
        </form>
      </div>

      <div class="col list-col">
        <h3>📖 Book List</h3>
        <table class="table">
          <thead>
            <tr>
              <th>Cover</th><th>Title</th><th>Author</th><th>Category</th><th>Year</th><th>Qty</th><th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = mysqli_fetch_assoc($books)): ?>
              <tr>
                <td><img src="<?=htmlspecialchars($row['cover_image']?:'uploads/default.png')?>" width="60" height="80" onerror="this.src='uploads/default.png'"></td>
                <td><?=htmlspecialchars($row['title'])?></td>
                <td><?=htmlspecialchars($row['author_name'])?></td>
                <td><?=htmlspecialchars($row['category_name'])?></td>
                <td><?=htmlspecialchars($row['year'])?></td>
                <td><?=htmlspecialchars($row['quantity'])?></td>
                <td>
                  <?php if(!empty($row['link'])): ?><a href="<?=htmlspecialchars($row['link'])?>" target="_blank">View</a> | <?php endif; ?>
                  <a href="book_edit.php?id=<?=$row['id']?>">Edit</a> |
                  <a href="book_delete.php?id=<?=$row['id']?>" onclick="return confirm('Delete?')">Delete</a> |
                  <a href="borrow.php?id=<?=$row['id']?>">Borrow</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="foot">
      <a href="authors.php">Manage authors</a> | <a href="categories.php">Manage categories</a> | <a href="loans.php">Loans</a>
    </div>
  </div>
</div>
</body>
</html>
