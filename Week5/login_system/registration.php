<?php
session_start();
include("db_connect.php");

if (isset($_POST['user']) && isset($_POST['password'])) {
    $name = $_POST['user'];
    $pass = md5($_POST['password']);
    $student_id = $_POST['student_id'];
    $class_name = $_POST['class_name'];
    $country = $_POST['country'];

    // Kiểm tra username trùng
    $check = mysqli_query($link, "SELECT * FROM userReg WHERE name='$name'");
    if (mysqli_num_rows($check) > 0) {
        echo "⚠️ Username already exists!";
    } else {
        $query = "INSERT INTO userReg (name, student_id, class_name, country, password)
                  VALUES ('$name', '$student_id', '$class_name', '$country', '$pass')";
        if (mysqli_query($link, $query)) {
            echo "✅ Registration successful!";
            header("refresh:2; url=login.php");
        } else {
            echo "❌ Error: " . mysqli_error($link);
        }
    }
} else {
    echo "Please fill in all fields.";
}
?>
