<?php
// authors.php
include "connection.php";
include "auth_check.php";
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_author'])) {
    $name = trim($_POST['name']);
    if ($name !== "") {
        $stmt = mysqli_prepare($link, "INSERT INTO authors (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $msg = "Author added.";
    }
}
$authors = mysqli_query($link, "SELECT * FROM authors ORDER BY name");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Authors</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container card centered small">
  <h2>Authors</h2>
  <?php if($msg) echo "<p class='ok'>$msg</p>"; ?>
  <form method="post">
    <input name="name" placeholder="Author name" required>
    <button name="add_author">Add</button>
  </form>
  <table class="table">
    <thead><tr><th>ID</th><th>Name</th><th>Actions</th></tr></thead>
    <tbody>
      <?php while($r = mysqli_fetch_assoc($authors)): ?>
        <tr>
          <td><?=$r['id']?></td>
          <td><?=htmlspecialchars($r['name'])?></td>
          <td>
            <a href="author_edit.php?id=<?=$r['id']?>">Edit</a> |
            <a href="author_delete.php?id=<?=$r['id']?>" onclick="return confirm('Delete?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <a href="home.php">Back</a>
</div>
</body>
</html>
