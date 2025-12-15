<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$uid  = $_SESSION['user_id'];
$role = $_SESSION['role']; // user | admin

$sql = "
SELECT 
    l.id,
    l.borrowed_at,
    l.due_date,
    l.returned_at,
    l.status,
    b.title,
    b.cover_image,
    b.link
FROM loans l
JOIN books b ON l.book_id = b.id
WHERE l.user_id = $uid
ORDER BY l.borrowed_at DESC
";

$result = mysqli_query($link, $sql);
if (!$result) {
    die("SQL ERROR: " . mysqli_error($link));
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>My Loans</title>
<link rel="stylesheet" href="style_v2.css">
</head>
<body>

<div class="page">
<div class="container">
<h2>📘 My Borrowed Books</h2>
<a href="home.php" class="btn">⬅ Back</a>

<?php if (mysqli_num_rows($result) == 0): ?>
    <p>You have not borrowed any books.</p>
<?php else: ?>

<table>
<tr>
    <th>Cover</th>
    <th>Title</th>
    <th>Borrowed</th>
    <th>Due</th>
    <th>Status</th>
    <th>Read</th>
    <th>Return</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
<td><img src="<?= $row['cover_image'] ?>" width="60"></td>
<td><?= $row['title'] ?></td>
<td><?= date("d/m/Y", strtotime($row['borrowed_at'])) ?></td>
<td><?= $row['due_date'] ? date("d/m/Y", strtotime($row['due_date'])) : "-" ?></td>
<td><?= ucfirst($row['status']) ?></td>

<td>
<?php if ($row['status'] === 'borrowed' && $row['link']): ?>
    <a href="<?= $row['link'] ?>" target="_blank">📖 Read</a>
<?php else: ?>
    -
<?php endif; ?>
</td>

<td>
<?php if ($row['status'] === 'borrowed'): ?>
    <a href="return.php?id=<?= $row['id'] ?>" onclick="return confirm('Return book?')">↩ Return</a>
<?php else: ?>
    -
<?php endif; ?>
</td>
</tr>
<?php endwhile; ?>

</table>
<?php endif; ?>
</div>
</div>
</body>
</html>
