<?php
session_start();
include "connection.php";

$msg = "";

if (isset($_POST['login'])) {
    $u = trim($_POST['username']);
    $p = md5($_POST['password']);

    $q = mysqli_prepare($link,
        "SELECT id, password_hash, role, blocked 
         FROM users WHERE username=?"
    );
    mysqli_stmt_bind_param($q, "s", $u);
    mysqli_stmt_execute($q);
    $res = mysqli_stmt_get_result($q);

    if ($row = mysqli_fetch_assoc($res)) {
        if ($row['blocked']) {
            $msg = "Tài khoản đã bị khóa do trả sách muộn!";
        } elseif ($row['password_hash'] === $p) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $u;
            $_SESSION['role'] = $row['role'];
            header("Location: home.php");
            exit;
        } else {
            $msg = "Sai mật khẩu!";
        }
    } else {
        $msg = "Sai tài khoản!";
    }
}
?>
