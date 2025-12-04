<?php
require "auth_check.php";
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    mysqli_query($conn, "INSERT INTO authors (name) VALUES ('$name')");
    header("Location: authors.php");
}
?>
<form method="POST">
<input name="name">
<button>Add</button>
</form>
