<?php
require "auth_check.php";
require "db.php";

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $name=$_POST["name"];
    mysqli_query($conn,"INSERT INTO categories(name) VALUES ('$name')");
    header("Location: categories.php");
}
?>
<form method="POST">
<input name="name">
<button>Add</button>
</form>
