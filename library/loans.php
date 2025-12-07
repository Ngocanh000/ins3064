<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];

// Lấy danh sách sách đang mượn
$loans = mysqli_query($link, "
    SELECT l.*, b.title, b.cover_image
    FROM loans l
    JOIN books b ON l.book_id = b.id
    WHERE l.user_id = $uid
    ORDER BY l.borrowed_at DESC
");
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
    <h2>📘 Sách bạn đã mượn</h2>
    <a href="home.php">⬅ Quay lại</a>
    <br><br>

    <table class="books">
        <tr>
            <th>Ảnh</th>
            <th>Tên sách</th>
            <th>Ngày mượn</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($loans)): ?>
        <tr>
            <td><img src="<?= $row['cover_image'] ?: 'uploads/default.png' ?>" width="60"></td>
            <td><?= $row['title'] ?></td>
            <td><?= $row['borrowed_at'] ?></td>
            <td>
                <?php if ($row['status'] == 'borrowed'): ?>
                    <span style="color:blue;">Đang mượn</span>
                <?php elseif ($row['status'] == 'returned'): ?>
                    <span style="color:green;">Đã trả</span>
                <?php else: ?>
                    <span style="color:red;">Quá hạn</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if ($row['status'] == 'borrowed'): ?>
                    <a href="return.php?id=<?= $row['id'] ?>" 
                       onclick="return confirm('Bạn muốn trả sách này?')">
                       Trả sách
                    </a>
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
