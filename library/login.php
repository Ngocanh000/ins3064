<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include "connection.php";

$msg = "";

if (isset($_POST["login"])) {
    $username = trim($_POST["username"]);
    $password = md5($_POST["password"]);

    $sql = "SELECT * FROM users WHERE username='$username' AND password_hash='$password'";
    $query = mysqli_query($link, $sql);

    if (!$query) {
        die(mysqli_error($link));
    }

    if (mysqli_num_rows($query) == 1) {
        $u = mysqli_fetch_assoc($query);

        $_SESSION["username"] = $u["username"];
        $_SESSION["user_id"]  = $u["id"];
        $_SESSION["role"]     = $u["role"];

        header("Location: home.php");
        exit();
    } else {
        $msg = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container small">
   <h2>Login</h2> 
    <?php if($msg) echo "<p style='color:red'>$msg</p>"; ?>

    <form method="post">
        <input name="username" placeholder="Username" required>
       <?php if($msg) echo "<p style='color:red'>$msg</p>"; ?>
        <button name="login">Đăng nhập</button>
    </form>

    <p>Chưa có tài khoản? <a href="register.php">Register</a></p>
</div>

</body>
</html>
