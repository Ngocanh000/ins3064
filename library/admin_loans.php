<?php
session_start();
include "connection.php";

if ($_SESSION["role"] != "admin") die("Không có quyền!");

$loans = mysqli_query($link,"
    SELECT l.*, b.title, u.username
    FROM loans l
    JOIN books b ON l.book_id=b.id
    JOIN users u ON l.user_id=u.id
    ORDER BY l.borrowed_at DESC
");
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><link rel="stylesheet" href="style.css">
<title>Lịch sử mượn</title></head>
<body>
<div class="container">

<h2>📖 Lịch sử mượn sách</h2>
<a href="home.php">⬅ Quay lại</a><br><br>

<table class="books">
<tr>
    <th>User</th>
    <th>Sách</th>
    <th>Ngày mượn</th>
    <th>Ngày trả</th>
    <th>Trạng thái</th>
    <th>Trả</th>
</tr>

<?php while($r = mysqli_fetch_assoc($loans)): ?>
<tr>
    <td><?= $r["username"] ?></td>
    <td><?= $r["title"] ?></td>
    <td><?= $r["borrowed_at"] ?></td>
    <td><?= $r["returned_at"] ?: "—" ?></td>
    <td><?= $r["status"] ?></td>
    <td>
        <?php if ($r["status"] == "borrowed"): ?>
            <a href="return.php?id=<?= $r['id'] ?>">Trả sách</a>
        <?php else: ?>—
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>

</table>

</div>
</body>
</html>
