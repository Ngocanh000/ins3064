<?php
session_start();
include "connection.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim(mysqli_real_escape_string($link, $_POST['username']));
    $password = md5($_POST['password']);

    $check = mysqli_query($link, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "Tên đăng nhập đã tồn tại!";
    } else {
        mysqli_query($link, "INSERT INTO users (username, password_hash) VALUES ('$username', '$password')");
        $msg = "Đăng ký thành công! <a href='login.php'>Đăng nhập</a>";
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><link rel="stylesheet" href="style.css"><title>Register</title></head>
<body>
<div class="container small">
    <h2>Đăng ký</h2>
    <?php if ($msg) echo "<p>$msg</p>"; ?>
    <form method="post">
        <input name="username" placeholder="Username" required>
        <input name="password" type="password" placeholder="Password" required>
        <button type="submit">Đăng ký</button>
    </form>
    <p>Đã có tài khoản? <a href="login.php">Login</a></p>
</div>
</body>
</html>
