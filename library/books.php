<?php
require "auth_check.php";
require "db.php";

$books = mysqli_query($conn, "
    SELECT books.*, authors.name AS author, categories.name AS category
    FROM books
    LEFT JOIN authors ON books.author_id = authors.id
    LEFT JOIN categories ON books.category_id = categories.id
");
?>
<h2>Books</h2>
<a href="book_add.php">+ Add Book</a> |
<a href="index.php">Home</a>
<table border="1" cellpadding="5">
<tr>
    <th>Title</th>
    <th>Author</th>
    <th>Category</th>
    <th>Year</th>
    <th>Qty</th>
    <th>Action</th>
</tr>

<?php while($b = mysqli_fetch_assoc($books)) { ?>
<tr>
    <td><?= $b["title"] ?></td>
    <td><?= $b["author"] ?></td>
    <td><?= $b["category"] ?></td>
    <td><?= $b["year"] ?></td>
    <td><?= $b["quantity"] ?></td>
    <td>
        <a href="book_edit.php?id=<?= $b['id'] ?>">Edit</a> |
        <a href="book_delete.php?id=<?= $b['id'] ?>" onclick="return confirm('Delete book?')">Delete</a>
    </td>
</tr>
<?php } ?>
</table>
