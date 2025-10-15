<?php
session_start();
include("db_connect.php");

if (isset($_POST['user']) && isset($_POST['password'])) {
    $name = $_POST['user'];
    $pass = md5($_POST['password']);

    $query = "SELECT * FROM userReg WHERE name='$name' AND password='$pass'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $name;
        header("location:home.php");
    } else {
        echo "❌ Invalid username or password!";
        header("refresh:2; url=login.php");
    }
}
?>
