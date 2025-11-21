<?php
include "connection.php"; // Kết nối database
session_start();

$msg = ""; // Khởi tạo biến thông báo

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']); // Lưu ý: tốt hơn dùng password_hash/password_verify

    // Sử dụng prepared statement để tránh SQL Injection
    $stmt = $link->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['username'] = $username;
        header("Location: home.php");
        exit();
    } else {
        $msg = "Invalid username or password!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small">
    <h2>Login</h2>
    <?php if (!empty($msg)) echo "<p style='color:red;'>$msg</p>"; ?>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Don’t have an account? <a href="register.php">Register</a></p>
</div>
</body>
</html>
