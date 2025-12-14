<?php
session_start(); include "connection.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$uid  = $_SESSION['user_id'];
$role = $_SESSION['role']; // admin | user
if ($_SESSION['role']!='admin') exit;
if ($role !== 'admin') {
    die("⛔ Bạn không có quyền truy cập");
}

if (isset($_POST['save'])) {
$id=$_POST['id'];
$days=$_POST['days'];
$block=$_POST['block'];
mysqli_query($link,
"UPDATE users SET loan_period_days=$days, blocked=$block WHERE id=$id"
);
}
$u = mysqli_query($link,"SELECT * FROM users");
?>
<!DOCTYPE html><html><head><link rel='stylesheet' href='style.css'></head>
<body><div class='container'><h2>Users</h2>
<?php while($r=mysqli_fetch_assoc($u)): ?>
<form method='post'>
<input type='hidden' name='id' value='<?= $r['id'] ?>'>
<?= $r['username'] ?> |
Days <input name='days' value='<?= $r['loan_period_days'] ?>' size='3'> |
Block <input type='checkbox' name='block' value='1' <?= $r['blocked']?'checked':'' ?>>
<button name='save'>Save</button>
</form>
<?php endwhile; ?>
</div></body></html>