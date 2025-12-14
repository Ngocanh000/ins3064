<?php
// setup_admin.php - run once to create an admin user
require_once "connection.php";

$username = 'admin';
$password = 'tuyencuulo'; // em có thể đổi
$email = 'admin@example.com';

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($link, "INSERT IGNORE INTO users (username, password_hash, role, email, loan_period_days) VALUES (?, ?, 'admin', ?, 30)");
mysqli_stmt_bind_param($stmt, "sss", $username, $hash, $email);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "Admin user created: $username / $password\n";
} else {
    echo "Admin may already exist or insert failed.\n";
}
mysqli_stmt_close($stmt);
