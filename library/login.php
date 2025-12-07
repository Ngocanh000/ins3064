<?php
// login.php
session_start();
include 'connection.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(mysqli_real_escape_string($link, $_POST['username']));
    $password = md5($_POST['password']);
    $res = mysqli_query($link, "SELECT * FROM users WHERE username='$username' AND password_hash='$password'");
    if ($res && mysqli_num_rows($res) === 1) {
        $user = mysqli_fetch_assoc($res);
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: home.php');
        exit();
    } else {
        $msg = "Tên hoặc mật khẩu không đúng.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="utf-8"><title>Login</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container small">
  <h2>Đăng nhập</h2>
  <?php if($msg) echo "<p class='msg'>$msg</p>"; ?>
  <form method="post">
    <input name="username" placeholder="Tên đăng nhập" required><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br>
    <button type="submit">Đăng nhập</button>
  </form>
  <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
</div>
</body>
</html>
