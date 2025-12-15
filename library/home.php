<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$uid  = $_SESSION['user_id'];
$role = $_SESSION['role'];

$q = "";
$where = "";

if (isset($_GET['q'])) {
    $q = trim($_GET['q']);
    $q = mysqli_real_escape_string($link, $q);

    if ($q !== "") {
        $where = "
            WHERE 
                b.title LIKE '%$q%' OR
                a.name LIKE '%$q%' OR
                c.name LIKE '%$q%' OR
                b.description LIKE '%$q%'
        ";
    }
}

$sql = "
SELECT b.*, 
       a.name AS author, 
       c.name AS category
FROM books b
LEFT JOIN authors a ON b.author_id = a.id
LEFT JOIN categories c ON b.category_id = c.id
$where
ORDER BY b.id DESC
";

$result = mysqli_query($link, $sql);
if (!$result) die(mysqli_error($link));
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Library Management System</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page">
<div class="container">

<h2>📚 Library Management System</h2>

<form method="get" class="search-box">
    <input type="text" name="q"
           placeholder="🔍 Tên sách / Tác giả / Thể loại / Mô tả"
           value="<?= htmlspecialchars($q) ?>">
    <button type="submit">Search</button>
</form>

<div class="top-actions">
    <a href="logout.php">Logout</a>

    <?php if ($role === 'admin'): ?>
        <a class="btn" href="book_add.php">➕ Add Book</a>
        <a class="btn" href="authors.php">Authors</a>
        <a class="btn" href="categories.php">Categories</a>
        <a class="btn" href="admin_loans.php">Loans</a>
        <a class="btn" href="admin_users.php">Users</a>
    <?php else: ?>
        <a class="btn" href="loans.php">📦 My Loans</a>
    <?php endif; ?>
</div>

<table>
<tr>
    <th>Cover</th>
    <th>Title</th>
    <th>Author</th>
    <th>Category</th>
    <th>Year</th>
    <th>Qty</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($result) == 0): ?>
<tr>
    <td colspan="7" style="color:red;font-weight:bold;text-align:center">
        ❌ Không tìm thấy sách phù hợp
    </td>
</tr>
<?php endif; ?>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td>
        <img src="<?= $row['cover_image'] ?: 'uploads/default.png' ?>"
             style="width:70px;border-radius:6px">
    </td>
    <td><?= htmlspecialchars($row['title']) ?></td>
    <td><?= htmlspecialchars($row['author']) ?></td>
    <td><?= htmlspecialchars($row['category']) ?></td>
    <td><?= $row['year'] ?></td>
    <td><?= $row['quantity'] ?></td>
    <td>
        <?php if ($role === 'admin'): ?>
            <a class="btn view" href="book_detail.php?id=<?= $row['id'] ?>">👁 Xem</a>
            <a class="btn edit" href="book_edit.php?id=<?= $row['id'] ?>">✏ Sửa</a>
            <a class="btn delete"
               href="book_delete.php?id=<?= $row['id'] ?>"
               onclick="return confirm('Xóa sách này?')">🗑 Xóa</a>
        <?php else: ?>
            <a class="btn view" href="book_detail.php?id=<?= $row['id'] ?>">📖 Xem chi tiết</a>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>

</table>
</div>
</div>
</body>
</html>
