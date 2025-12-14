<?php
session_start();
include "connection.php";
if ($_SESSION["role"] != "admin") die("Access denied");

$msg = "";

if (isset($_POST["add"])) {
    $name = trim($_POST["name"]);
    if ($name != "") {
        mysqli_query($link, "INSERT IGNORE INTO authors(name) VALUES('$name')");
    }
}

if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $name = trim($_POST["name"]);

    $used = mysqli_query($link,"SELECT * FROM books WHERE author_id=$id");
    if (mysqli_num_rows($used) > 0 && $name=="") {
        $msg = "Không thể xoá tác giả đang có sách!";
    } else {
        if ($name=="") $name = "[DELETED]";
        mysqli_query($link,"UPDATE authors SET name='$name' WHERE id=$id");
    }
}

$authors = mysqli_query($link,"SELECT * FROM authors");
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><link rel="stylesheet" href="style.css"></head>
<body>
<h2>Quản lý tác giả</h2>
<p style="color:red"><?= $msg ?></p>

<form method="post">
<input name="name" placeholder="Tên tác giả" required>
<button name="add">Thêm</button>
</form>

<hr>

<?php while($a=mysqli_fetch_assoc($authors)){ ?>
<form method="post">
<input type="hidden" name="id" value="<?= $a['id'] ?>">
<input name="name" value="<?= $a['name'] ?>">
<button name="update">Lưu</button>
</form>
<?php } ?>
</body>
</html>
