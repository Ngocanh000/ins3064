<?php
// register.php
include "connection.php";
session_start();

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username === "" || $password === "") {
        $msg = "Username and password are required.";
    } else {
        // check exists
        $stmt = mysqli_prepare($link, "SELECT id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $msg = "Username already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = mysqli_prepare($link, "INSERT INTO users (username, password_hash, role) VALUES (?, ?, 'user')");
            mysqli_stmt_bind_param($ins, "ss", $username, $hash);
            if (mysqli_stmt_execute($ins)) {
                $msg = "Registration successful. <a href='login.php'>Login here</a>.";
            } else {
                $msg = "Database error: " . mysqli_error($link);
            }
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small card">
  <h2>Register</h2>
  <?php if($msg) echo "<p class='msg'>".$msg."</p>"; ?>
  <form method="post">
    <input name="username" placeholder="Username" required>
    <input name="password" type="password" placeholder="Password" required>
    <button name="register" type="submit">Register</button>
  </form>
  <p>Already have account? <a href="login.php">Login</a></p>
</div>
</body>
</html>
