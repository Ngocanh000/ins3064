<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) die("Invalid ID");

$user = mysqli_fetch_assoc(mysqli_query($link, "
    SELECT * FROM users
    WHERE id = $id AND role = 'user'
"));
if (!$user) die("User not found");

if (isset($_POST['save'])) {
    $loan_days = intval($_POST['loan_period_days']);
    $blocked   = isset($_POST['blocked']) ? 1 : 0;
    $late      = intval($_POST['late_count']);

    mysqli_query($link, "
        UPDATE users SET
            loan_period_days = $loan_days,
            blocked = $blocked,
            late_count = $late
        WHERE id = $id
    ");

    header("Location: admin_users.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Edit User</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container small">
<h2>✏ Sửa người dùng</h2>

<form method="post">

<label>Username</label>
<input value="<?= htmlspecialchars($user['username']) ?>" disabled>

<label>Loan period (days)</label>
<input type="number" name="loan_period_days"
       value="<?= $user['loan_period_days'] ?>" min="1">

<label>Late count</label>
<input type="number" name="late_count"
       value="<?= $user['late_count'] ?>" min="0">

<label>
<input type="checkbox" name="blocked"
<?= $user['blocked'] ? 'checked' : '' ?>>
 Block user
</label>

<br><br>
<button class="btn" name="save">💾 Save</button>
<a href="admin_users.php" class="btn">Cancel</a>

</form>
</div>

</body>
</html>
