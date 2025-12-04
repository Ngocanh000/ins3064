<?php
include "connection.php";
include "auth_check.php";

$loans = mysqli_query($link, "SELECT l.*, b.title FROM loans l LEFT JOIN books b ON l.book_id=b.id ORDER BY l.borrowed_at DESC");

// handle return action
if (isset($_GET['return']) && intval($_GET['return'])) {
    $id = intval($_GET['return']);
    // update loan and increment book quantity
    $stmt = mysqli_prepare($link, "SELECT book_id, quantity FROM loans WHERE id = ? AND returned_at IS NULL");
    mysqli_stmt_bind_param($stmt,"i",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$book_id,$q);
    if (mysqli_stmt_fetch($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_begin_transaction($link);
        $u = mysqli_prepare($link, "UPDATE loans SET returned_at = NOW(), status='returned' WHERE id = ?");
        mysqli_stmt_bind_param($u,"i",$id);
        mysqli_stmt_execute($u);
        mysqli_stmt_close($u);
        $v = mysqli_prepare($link, "UPDATE books SET quantity = quantity + ? WHERE id = ?");
        mysqli_stmt_bind_param($v,"ii",$q,$book_id);
        mysqli_stmt_execute($v);
        mysqli_stmt_close($v);
        mysqli_commit($link);
    } else {
        mysqli_stmt_close($stmt);
    }
    header("Location: loans.php");
    exit();
}
?>
<!doctype html><html><head><meta charset="utf-8"><link rel="stylesheet" href="style.css"></head><body>
<div class="container card centered large">
  <h2>Loans</h2>
  <table class="table">
    <thead><tr><th>ID</th><th>User</th><th>Book</th><th>Qty</th><th>Borrowed</th><th>Due</th><th>Returned</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
      <?php while($r = mysqli_fetch_assoc($loans)): ?>
        <?php
          $user_name = null;
          $uu = mysqli_query($link, "SELECT username FROM users WHERE id=".$r['user_id']);
          if ($uu) { $un = mysqli_fetch_assoc($uu); $user_name = $un['username']; }
        ?>
        <tr>
          <td><?=$r['id']?></td>
          <td><?=htmlspecialchars($user_name)?></td>
          <td><?=htmlspecialchars($r['title'])?></td>
          <td><?=$r['quantity']?></td>
          <td><?=$r['borrowed_at']?></td>
          <td><?=$r['due_date']?></td>
          <td><?=$r['returned_at']?></td>
          <td><?=$r['status']?></td>
          <td>
            <?php if($r['returned_at'] == null): ?>
              <a href="loans.php?return=<?=$r['id']?>" onclick="return confirm('Return?')">Return</a>
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <a href="home.php">Back</a>
</div>
</body></html>
