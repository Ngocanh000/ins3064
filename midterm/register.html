<?php
include "connection.php";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']);
    $check = mysqli_query($link, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "Username already exists!";
    } else {
        mysqli_query($link, "INSERT INTO users(username, password) VALUES('$username','$password')");
        $msg = "Registration successful! <a href='login.php'>Login here</a>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small">
    <h2>Register</h2>
    <?php if (!empty($msg)) echo "<p>$msg</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="register">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>
