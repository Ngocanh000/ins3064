<?php
session_start();
include "connection.php";
if ($_SESSION["role"] != "admin") exit();

$cats = mysqli_query($link, "SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><link rel="stylesheet" href="style.css"><title>Categories</title></head>
<body>
<div class="container">
<h2>Danh sách thể loại</h2>

<table>
<tr><th>ID</th><th>Tên</th></tr>
<?php while($c=mysqli_fetch_assoc($cats)): ?>
<tr>
    <td><?= $c['id'] ?></td>
    <td><?= $c['name'] ?></td>
</tr>
<?php endwhile; ?>
</table>

</div>
</body>
</html>
