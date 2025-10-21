<?php
include "connection.php"; // Kết nối database

// --- Lấy ID user từ URL ---
if (!isset($_GET["id"])) {
    die("⚠️ Missing user ID.");
}
$id = intval($_GET["id"]);

// --- Lấy dữ liệu người dùng theo ID ---
$res = mysqli_query($link, "SELECT * FROM users WHERE id=$id");
if (mysqli_num_rows($res) == 0) {
    die("⚠️ User not found.");
}
$row = mysqli_fetch_assoc($res);

// --- Cập nhật khi nhấn nút Update ---
if (isset($_POST["update"])) {
    $firstname = $_POST["firstname"];
    $lastname  = $_POST["lastname"];
    $email     = $_POST["email"];
    $contact   = $_POST["contact"];

    $query = "UPDATE users 
              SET firstname='$firstname',
                  lastname='$lastname',
                  email='$email',
                  contact='$contact'
              WHERE id=$id";

    mysqli_query($link, $query);

    echo "<script>alert('✅ Update successful!'); window.location='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Edit User</h2>
    <form method="post">
        <div class="form-group">
            <label>First name:</label>
            <input type="text" name="firstname" class="form-control"
                   value="<?= htmlspecialchars($row['firstname']) ?>" required>
        </div>
        <div class="form-group">
            <label>Last name:</label>
            <input type="text" name="lastname" class="form-control"
                   value="<?= htmlspecialchars($row['lastname']) ?>" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control"
                   value="<?= htmlspecialchars($row['email']) ?>" required>
        </div>
        <div class="form-group">
            <label>Contact:</label>
            <input type="text" name="contact" class="form-control"
                   value="<?= htmlspecialchars($row['contact']) ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-default">Back</a>
    </form>
</div>
</body>
</html>
