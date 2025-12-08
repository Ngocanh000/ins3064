<?php
session_start();
include "connection.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "
    SELECT l.*, b.title, b.cover_image, b.link
    FROM loans l
    JOIN books b ON l.book_id=b.id
    WHERE l.user_id=$user_id
    ORDER BY l.borrowed_at DESC
";

$result = mysqli_query($link, $sql);

if (!$result) {
    echo "<h3>SQL ERROR:</h3>";
    echo mysqli_error($link);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<title>Sách đã mượn</title>
</head>
<body>

<div class="container">
<h2>📘 Sách đã mượn</h2>

<a href="home.php">⬅ Quay lại</a><br><br>

<table class="books">
<tr>
    <th>Ảnh</th>
    <th>Tên sách</th>
    <th>Ngày mượn</th>
    <th>Trạng thái</th>
    <th>Đọc</th>
    <th>Trả</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><img src="<?= $row['cover_image'] ?>" width="80"></td>
    <td><?= $row['title'] ?></td>
    <td><?= $row['borrowed_at'] ?></td>
    <td><?= $row['status'] ?></td>

    <td>
        <a href="<?= $row['link'] ?>" target="_blank">📖 Đọc</a>
    </td>

    <td>
        <?php if ($row['status'] == "borrowed"): ?>
            <a href="return.php?id=<?= $row['id'] ?>">Trả</a>
        <?php else: ?>
            —
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>

</table>

</div>
</body>
</html>
