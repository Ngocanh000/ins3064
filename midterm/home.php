<?php
include("connection.php");
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add'])) {
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $author = mysqli_real_escape_string($link, $_POST['author']);
    $category = mysqli_real_escape_string($link, $_POST['category']);
    $year = intval($_POST['year']);
    $quantity = intval($_POST['quantity']);
    $book_link = mysqli_real_escape_string($link, $_POST['book_link']);
    $description = mysqli_real_escape_string($link, $_POST['description']);

    $target_dir = "uploads/";
    $cover_path = "uploads/default.png"; 
    if (isset($_FILES["cover"]) && $_FILES["cover"]["error"] === UPLOAD_ERR_OK) {
        $file_name = basename($_FILES["cover"]["name"]);
        $target_file = $target_dir . $file_name;
        move_uploaded_file($_FILES["cover"]["tmp_name"], $target_file);
        $cover_path = $target_file;
    }

    $query = "INSERT INTO books (title, author, category, year, quantity, link, description, cover_image)
              VALUES ('$title', '$author', '$category', $year, $quantity, '$book_link', '$description', '$cover_path')";
    mysqli_query($link, $query);

    header("Location: home.php");
    exit();
}

$books = mysqli_query($link, "SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>📚 Library Management System</h2>
    <p style="color: red;">
        Welcome, <b><?= htmlspecialchars($_SESSION['username']) ?></b> |
        <a href="logout.php">Logout</a></p>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Book title" required>
        <input type="text" name="author" placeholder="Author">
        <input type="text" name="category" placeholder="Category">
        <input type="number" name="year" placeholder="Year">
        <input type="number" name="quantity" placeholder="Quantity">
        <input type="text" name="book_link" placeholder="Book link (optional)">
        <textarea name="description" placeholder="Short description..."></textarea>
        <label>Upload Cover:</label>
        <input type="file" name="cover">
        <button type="submit" name="add">Add Book</button>
    </form>

    <hr>

    <h3>📖 Book List</h3>
    <table>
        <tr>
            <th>Cover</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Year</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($books)) { ?>
            <tr>
                <td>
                    <img src="<?= htmlspecialchars($row['cover_image']) ?>"
                         width="70" height="90"
                         onerror="this.src='uploads/default.png'">
                </td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td><?= htmlspecialchars($row['year']) ?></td>
                <td>
                    <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank">📘 View</a> |
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="delete.php?id=<?= $row['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
