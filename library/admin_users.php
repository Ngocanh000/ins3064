<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* CHỈ LẤY USER */
$users = mysqli_query($link, "
    SELECT * FROM users
    WHERE role = 'user'
    ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Users</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>👥 Quản lý người dùng</h2>
<a href="home.php" class="btn">⬅ Home</a>
<br><br>

<table class="books">
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Loan days</th>
    <th>Late</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while ($u = mysqli_fetch_assoc($users)): ?>
<tr>
    <td><?= $u['id'] ?></td>
    <td><?= htmlspecialchars($u['username']) ?></td>
    <td><?= $u['loan_period_days'] ?></td>
    <td><?= $u['late_count'] ?></td>
    <td>
        <?= $u['blocked'] ? '<span style="color:red">Blocked</span>' : 'Active' ?>
    </td>
    <td>
        <!-- 🔑 QUAN TRỌNG: TRUYỀN ?id= -->
        <a class="btn edit"
           href="admin_user_edit.php?id=<?= $u['id'] ?>">
           ✏ Edit
        </a>
    </td>
</tr>
<?php endwhile; ?>

</table>
</div>

</body>
</html>
