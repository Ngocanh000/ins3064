<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
</head>
<body style="text-align:center; margin-top:100px;">
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <p>You have successfully logged in.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
