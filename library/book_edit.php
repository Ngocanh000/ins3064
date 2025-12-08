<?php
session_start();
include "connection.php";

if ($_SESSION["role"] != "admin") exit();

$id = intval($_GET["id"]);
$book = mysqli_fetch_assoc(mysqli_query($link,
    "SELECT * FROM books WHERE id=$id"
));
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><link rel="stylesheet" href="style.css">
<title>Sửa sách</title></head>
<body>
<div class="container small">

<h2>Sửa sách</h2>

<form method="post" enctype="multipart/form-data">

<input name="title" value="<?= $book['title'] ?>" required>
<input name="year" type="number" value="<?= $book['year'] ?>">
<input name="quantity" type="number" value="<?= $book['quantity'] ?>">
<textarea name="description"><?= $book['description'] ?></textarea>
<input type="file" name="cover">

<button name="save">Lưu thay đổi</button>
</form>

<?php
if (isset($_POST["save"])) {

    $title = $_POST["title"];
    $year = $_POST["year"];
    $quantity = $_POST["quantity"];
    $description = mysqli_real_escape_string($link, $_POST["description"]);

    $img = $book["cover_image"];
    if (!empty($_FILES["cover"]["name"])) {
        $img = "uploads/" . time() . "_" . $_FILES["cover"]["name"];
        move_uploaded_file($_FILES["cover"]["tmp_name"], $img);
    }

    mysqli_query($link,
        "UPDATE books SET 
            title='$title',
            year=$year,
            quantity=$quantity,
            description='$description',
            cover_image='$img'
        WHERE id=$id"
    );

    header("Location: home.php");
}
?>

</div>
</body>
</html>
