<?php
include "connection.php";
include "auth_check.php";
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_cat'])) {
    $name = trim($_POST['name']);
    if ($name !== "") {
        $stmt = mysqli_prepare($link, "INSERT INTO categories (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $msg = "Category added.";
    }
}
$cats = mysqli_query($link, "SELECT * FROM categories ORDER BY name");
?>
<!doctype html>
<html><head><meta charset="utf-8"><link rel="stylesheet" href="style.css"></head><body>
<div class="container small card centered">
  <h2>Categories</h2>
  <?php if($msg) echo "<p class='ok'>$msg</p>"; ?>
  <form method="post">
    <input name="name" placeholder="Category name" required>
    <button name="add_cat">Add</button>
  </form>
  <table class="table">
    <thead><tr><th>ID</th><th>Name</th><th>Actions</th></tr></thead>
    <tbody>
      <?php while($r=mysqli_fetch_assoc($cats)): ?>
        <tr>
          <td><?=$r['id']?></td>
          <td><?=htmlspecialchars($r['name'])?></td>
          <td><a href="category_edit.php?id=<?=$r['id']?>">Edit</a> | <a href="category_delete.php?id=<?=$r['id']?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <a href="home.php">Back</a>
</div>
</body></html>
