<?php
require "auth_check.php";
require "db.php";

$authors = mysqli_query($conn, "SELECT * FROM authors");
$categories = mysqli_query($conn, "SELECT * FROM categories");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $author = $_POST["author_id"];
    $category = $_POST["category_id"];
    $year = $_POST["year"];
    $qty = $_POST["quantity"];
    $link = $_POST["link"];
    $desc = $_POST["description"];

    $image = "uploads/" . time() . "_" . $_FILES["cover"]["name"];
    move_uploaded_file($_FILES["cover"]["tmp_name"], $image);

    $sql = "INSERT INTO books (title, author_id, category_id, year, quantity, link, description, cover_image)
            VALUES ('$title',$author,$category,$year,$qty,'$link','$desc','$image')";
    mysqli_query($conn, $sql);

    header("Location: books.php");
}
?>
<h2>Add Book</h2>
<form method="POST" enctype="multipart/form-data">
Title: <input name="title"><br>
Author:
<select name="author_id">
<?php while($a=mysqli_fetch_assoc($authors)){ ?>
<option value="<?= $a['id'] ?>"><?= $a['name'] ?></option>
<?php } ?>
</select><br>

Category:
<select name="category_id">
<?php while($c=mysqli_fetch_assoc($categories)){ ?>
<option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
<?php } ?>
</select><br>

Year: <input name="year"><br>
Quantity: <input name="quantity"><br>
Link: <input name="link"><br>
Description:<br>
<textarea name="description"></textarea><br>
Cover image: <input type="file" name="cover"><br><br>
<button>Add</button>
</form>
