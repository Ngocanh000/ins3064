<?php
include("connection.php");

// INSERT
if (isset($_POST['insert'])) {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $query = "INSERT INTO laptops (brand, model, price, stock)
              VALUES ('$brand', '$model', '$price', '$stock')";
    mysqli_query($link, $query);
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $query = "UPDATE laptops 
              SET brand='$brand', model='$model', price='$price', stock='$stock' 
              WHERE id=$id";
    mysqli_query($link, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laptop Shop Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" 
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="text-center">Laptop Shop Database</h2>

    <!-- FORM INPUT -->
    <form action="" method="post">
        <div class="form-group">
            <label>Brand:</label>
            <input type="text" name="brand" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Model:</label>
            <input type="text" name="model" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Price ($):</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Stock:</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <button type="submit" name="insert" class="btn btn-success">Add Laptop</button>
    </form>

    <hr>

    <!-- TABLE DISPLAY -->
    <h3>Current Inventory</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Brand</th><th>Model</th><th>Price ($)</th><th>Stock</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = mysqli_query($link, "SELECT * FROM laptops");
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['brand']}</td>
                    <td>{$row['model']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['stock']}</td>
                    <td>
                      <a href='edit.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>;
                      <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>;
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
