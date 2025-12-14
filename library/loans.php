<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['user_id'];

$sql = "
SELECT l.*, b.title, b.cover
FROM loans l
JOIN books b ON l.book_id = b.id
WHERE l.user_id = $uid
ORDER BY l.borrowed_at DESC
";

$result = mysqli_query($link, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>My Loans</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>📦 My Borrowed Books</h2>
<a class="btn" href="home.php">⬅ Back</a>

<table>
<tr>
    <th>Cover</th>
    <th>Title</th>
    <th>Borrowed</th>
    <th>Due</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><img src="uploads/<?= $row['cover'] ?>" width="60"></td>
    <td><?= $row['title'] ?></td>
    <td><?= $row['borrowed_at'] ?></td>
    <td><?= $row['due_date'] ?></td>
    <td><?= $row['status'] ?></td>
    <td>
        <?php if ($row['status'] === 'borrowed'): ?>
            <a class="btn" href="return.php?id=<?= $row['id'] ?>">↩ Trả sách</a>
        <?php else: ?>
            ✔ Đã trả
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
</div>

</body>
</html>
