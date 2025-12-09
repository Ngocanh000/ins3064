<?php
session_start();
include "connection.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];
$role = $_SESSION["role"];
$uid = $_SESSION["user_id"];

// ======================= SEARCH HANDLER ================================
$searchQuery = "";
$keyword = "";

if (isset($_GET['search']) && trim($_GET['search']) != "") {
    $keyword = mysqli_real_escape_string($link, $_GET['search']);

    $searchQuery = "
        WHERE 
            b.title LIKE '%$keyword%' OR
            a.name LIKE '%$keyword%' OR
            c.name LIKE '%$keyword%' OR
            b.description LIKE '%$keyword%'
    ";
}

// ======================= SQL GET BOOKS ================================
$sql = "
    SELECT b.*, a.name AS author_name, c.name AS category_name
    FROM books b
    LEFT JOIN authors a ON b.author_id = a.id
    LEFT JOIN categories c ON b.category_id = c.id
    $searchQuery
    ORDER BY b.id DESC
";

$books = mysqli_query($link, $sql);

if (!$books) {
    die("SQL ERROR: " . mysqli_error($link));
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<title>Home</title>
</head>
<body>

<div class="container">
    <h2>📚 Library — Xin chào <?= $username ?></h2>
    <a href="logout.php">Đăng xuất</a>
    <br><br>

    <?php if ($role == "admin"): ?>
        <a class="btn" href="book_add.php">➕ Thêm sách</a>
        <a class="btn" href="authors.php">✍ Tác giả</a>
        <a class="btn" href="categories.php">📂 Thể loại</a>
    <?php endif; ?>
    
    <a class="btn" href="loans.php">📘 Sách đã mượn</a>

    <hr>

    <!-- ================= SEARCH BAR ================= -->
    <form method="get" style="margin-bottom:20px;">
        <input type="text" name="search" placeholder="Search by title, author, category, description..."
               value="<?= $keyword ?>" 
               style="padding:8px; width:300px;">
        <button type="submit" class="btn">Search</button>
    </form>

    <h3>Danh sách sách</h3>

    <table class="books">
        <tr>
            <th>Ảnh</th>
            <th>Tiêu đề</th>
            <th>Tác giả</th>
            <th>Thể loại</th>
            <th>SL</th>
            <th>Hành động</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($books)): ?>
            <tr>
                <td><img src="<?= $row['cover_image'] ?: 'uploads/default.png' ?>" width="60"></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['author_name'] ?></td>
                <td><?= $row['category_name'] ?></td>
                <td><?= $row['quantity'] ?></td>

                <td>
                    <?php if ($role == "admin"): ?>
                        <a href="book_edit.php?id=<?= $row['id'] ?>">Sửa</a> |
                        <a href="book_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Xóa sách?')">Xóa</a>

                    <?php else: ?>
                        <?php if ($row['quantity'] > 0): ?>
                            <a href="borrow.php?id=<?= $row['id'] ?>">Mượn</a>
                        <?php else: ?>
                            Hết sách
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>

    </table>

</div>

</body>
</html>
