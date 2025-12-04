<?php
include "connection.php";
include "auth_check.php";
$id = intval($_GET['id'] ?? 0);
if (!$id) { header("Location: authors.php"); exit(); }
$stmt = mysqli_prepare($link, "SELECT * FROM authors WHERE id = ?");
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);
if (!$row) { header("Location: authors.php"); exit(); }

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name = trim($_POST['name']);
    if ($name !== "") {
        $stmt = mysqli_prepare($link, "UPDATE authors SET name=? WHERE id=?");
        mysqli_stmt_bind_param($stmt,"si",$name,$id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: authors.php");
        exit();
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><link rel="stylesheet" href="style.css"></head><body>
<div class="container small card centered">
  <h2>Edit Author</h2>
  <form method="post">
    <input name="name" value="<?=htmlspecialchars($row['name'])?>">
    <button type="submit">Save</button>
    <a href="authors.php">Back</a>
  </form>
</div>
</body></html>
