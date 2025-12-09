<?php
session_start();
include "connection.php";

$msg = "";

if (isset($_POST["register"])) {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $password_hash = md5($password);  

    // kiểm tra rỗng
    if ($username == "" || $password == "") {
        $msg = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        // kiểm tra trùng username
        $check = mysqli_query($link,
            "SELECT * FROM users WHERE username='$username'"
        );

        if (mysqli_num_rows($check) > 0) {
            $msg = "Tên đăng nhập đã tồn tại!";
        } else {
            // thêm user mới
            mysqli_query($link,
                "INSERT INTO users (username, password_hash, role)
                 VALUES ('$username', '$password_hash', 'user')"
            );

            $msg = "Đăng ký thành công! Đang chuyển hướng...";
            header("refresh:1; url=login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container small">
    <h2>Đăng ký tài khoản</h2>

    <?php if ($msg) echo "<p>$msg</p>"; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>

        <button type="submit" name="register">Đăng ký</button>
    </form>

    <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
</div>
</body>
</html>
