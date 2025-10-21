<?php
include "connection.php"; // Kết nối CSDL

if (!isset($_GET["id"])) {
    die("⚠️ Missing user ID.");
}

$id = intval($_GET["id"]);

// Xoá user
$query = "DELETE FROM users WHERE id=$id";
if (mysqli_query($link, $query)) {
    echo "<script>alert('🗑️ User deleted successfully!'); window.location='index.php';</script>";
} else {
    echo "<script>alert('❌ Delete failed: " . mysqli_error($link) . "'); window.location='index.php';</script>";
}
?>
