<?php
session_start();
include "connection.php";

$msg = "";

if (isset($_POST["register"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $password_hash = md5($password);

    // Check trùng username
    $check = mysqli_query($link, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "Tên đăng nhập đã tồn tại!";
    } else {
        mysqli_query($link, "
            INSERT INTO users(username, password, role)
            VALUES('$username', '$password_hash', 'user')
        ");
        $msg = "Đăng ký thành công! Hãy đăng nhập.";
        header("refresh:1; url=login.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <h2>Đăng ký tài khoản</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>

        <button type="submit" name="register">Đăng ký</button>
    </form>

    <p style="color:red;"><?= $msg ?></p>

    <a href="login.php">Đã có tài khoản? Đăng nhập</a>
</div>

</body>
</html>
