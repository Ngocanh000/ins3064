<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$sql = "
SELECT l.*, 
       u.username, 
       b.title
FROM loans l
JOIN users u ON l.user_id = u.id
JOIN books b ON l.book_id = b.id
ORDER BY l.borrowed_at DESC
";

$result = mysqli_query($link, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Loans</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>📋 Loan Management</h2>
<a class="btn" href="home.php">⬅ Back</a>

<table>
<tr>
    <th>User</th>
    <th>Book</th>
    <th>Borrowed</th>
    <th>Due</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $row['username'] ?></td>
    <td><?= $row['title'] ?></td>
    <td><?= $row['borrowed_at'] ?></td>
    <td><?= $row['due_date'] ?></td>
    <td><?= $row['status'] ?></td>
    <td>
        <a class="btn" href="book_detail.php?id=<?= $row['book_id'] ?>">👁 Xem sách</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</div>

</body>
</html>
