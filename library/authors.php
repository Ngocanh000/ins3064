<?php
session_start();
include "connection.php";
if ($_SESSION["role"] != "admin") exit();

$authors = mysqli_query($link, "SELECT * FROM authors");
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><link rel="stylesheet" href="style.css"><title>Authors</title></head>
<body>
<div class="container">
<h2>Danh sách tác giả</h2>

<table>
<tr><th>ID</th><th>Tên</th></tr>
<?php while($a=mysqli_fetch_assoc($authors)): ?>
<tr>
    <td><?= $a['id'] ?></td>
    <td><?= $a['name'] ?></td>
</tr>
<?php endwhile; ?>
</table>

</div>
</body>
</html>
