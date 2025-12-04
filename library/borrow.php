<?php
include "connection.php";
include "auth_check.php";

$book_id = intval($_GET['id'] ?? 0);
if (!$book_id) { header("Location: home.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {
    $qty = max(1, intval($_POST['qty']));
    // check stock
    $stmt = mysqli_prepare($link, "SELECT quantity FROM books WHERE id = ?");
    mysqli_stmt_bind_param($stmt,"i",$book_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$stock);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    if ($stock === null || $stock < $qty) {
        $err = "Not enough stock.";
    } else {
        // insert loan and decrement quantity (transaction)
        mysqli_begin_transaction($link);
        $stmt = mysqli_prepare($link, "INSERT INTO loans (user_id, book_id, quantity, due_date) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 14 DAY))");
        mysqli_stmt_bind_param($stmt,"iii", $_SESSION['user_id'], $book_id, $qty);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($link, "UPDATE books SET quantity = quantity - ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt,"ii",$qty,$book_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_commit($link);
        header("Location: loans.php");
        exit();
    }
}

// fetch book title
$stmt = mysqli_prepare($link, "SELECT title, quantity FROM books WHERE id = ?");
mysqli_stmt_bind_param($stmt,"i",$book_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,$title,$quantity);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>
<!doctype html>
<html><head><meta charset="utf-8"><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container small card centered">
  <h2>Borrow: <?=htmlspecialchars($title)?></h2>
  <?php if(!empty($err)) echo "<p class='err'>$err</p>"; ?>
  <p>Available: <?=$quantity?></p>
  <form method="post">
    <input name="qty" type="number" value="1" min="1">
    <button name="borrow">Borrow</button>
  </form>
  <a href="home.php">Back</a>
</div>
</body>
</html>
