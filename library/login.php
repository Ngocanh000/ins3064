<?php
// login.php
include "connection.php";
session_start();
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($link, "SELECT id, password_hash, role FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $hash, $role);
    if (mysqli_stmt_fetch($stmt)) {
        if (password_verify($password, $hash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            header("Location: home.php");
            exit();
        } else {
            $msg = "Incorrect password.";
        }
    } else {
        $msg = "User not found.";
    }
    mysqli_stmt_close($stmt);
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small card">
  <h2>Login</h2>
  <?php if($msg) echo "<p class='msg'>".$msg."</p>"; ?>
  <form method="post">
    <input name="username" placeholder="Username" required>
    <input name="password" type="password" placeholder="Password" required>
    <button name="login" type="submit">Login</button>
  </form>
  <p>No account? <a href="register.php">Register</a></p>
</div>
</body>
</html>
