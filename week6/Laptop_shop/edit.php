<?php
include("connection.php");

// --- Kiểm tra id truyền vào ---
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("❌ Error: No laptop ID provided.");
}

$id = intval($_GET['id']); // Ép kiểu tránh SQL injection

// --- Lấy dữ liệu laptop ---
$result = mysqli_query($link, "SELECT * FROM laptops WHERE id = $id");
if (!$result || mysqli_num_rows($result) == 0) {
    die("❌ Error: Laptop not found.");
}

$row = mysqli_fetch_assoc($result);

// --- Khi người dùng bấm 'Update' ---
if (isset($_POST['update'])) {
    $brand = mysqli_real_escape_string($link, $_POST['brand']);
    $model = mysqli_real_escape_string($link, $_POST['model']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    $update = "UPDATE laptops 
               SET brand='$brand', model='$model', price='$price', stock='$stock'
               WHERE id=$id";

    if (mysqli_query($link, $update)) {
        header("Location: index.php?updated=1");
        exit();
    } else {
        echo "<div class='alert alert-danger'>❌ Update failed: " . mysqli_error($link) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Laptop</title>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="text-center" style="margin-top:30px;">Edit Laptop</h2>
    <form method="post" class="col-md-6 col-md-offset-3">

        <div class="form-group">
            <label>Brand:</label>
            <input type="text" name="brand" class="form-control" 
                   value="<?= htmlspecialchars($row['brand']) ?>" required>
        </div>

        <div class="form-group">
            <label>Model:</label>
            <input type="text" name="model" class="form-control" 
                   value="<?= htmlspecialchars($row['model']) ?>" required>
        </div>

        <div class="form-group">
            <label>Price ($):</label>
            <input type="number" step="0.01" name="price" class="form-control"
                   value="<?= htmlspecialchars($row['price']) ?>" required>
        </div>

        <div class="form-group">
            <label>Stock:</label>
            <input type="number" name="stock" class="form-control" 
                   value="<?= htmlspecialchars($row['stock']) ?>" required>
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-default">Back</a>
    </form>
</div>
</body>
</html>
