<?php
include "connection.php"; // Kết nối CSDL
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <!-- FORM -->
    <div class="col-lg-4">
        <h2>User Data Form</h2>
        <form method="post">
            <div class="form-group">
                <label for="firstname">First name:</label>
                <input type="text" class="form-control" id="firstname"
                       placeholder="Enter first name" name="firstname" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last name:</label>
                <input type="text" class="form-control" id="lastname"
                       placeholder="Enter last name" name="lastname" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email"
                       placeholder="Enter email" name="email" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact:</label>
                <input type="text" class="form-control" id="contact"
                       placeholder="Enter contact" name="contact" required>
            </div>
            <button type="submit" name="insert" class="btn btn-success">Insert</button>
            <button type="submit" name="update" class="btn btn-warning">Update</button>
            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
        </form>
    </div>

    <!-- TABLE -->
    <div class="col-lg-12">
        <h3>All Users</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $res = mysqli_query($link, "SELECT * FROM users");
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . htmlspecialchars($row["firstname"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["lastname"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["contact"]) . "</td>";
                echo "<td><a href='edit.php?id={$row["id"]}' class='btn btn-info'>Edit</a></td>";
                echo "<td><a href='delete.php?id={$row["id"]}' class='btn btn-danger'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// --- INSERT ---
if (isset($_POST["insert"])) {
    $query = "INSERT INTO users (firstname, lastname, email, contact)
              VALUES ('{$_POST['firstname']}','{$_POST['lastname']}','{$_POST['email']}','{$_POST['contact']}')";
    mysqli_query($link, $query);
    echo "<script>window.location.href = window.location.href;</script>";
}

// --- UPDATE ---
if (isset($_POST["update"])) {
    $query = "UPDATE users SET 
              lastname='{$_POST['lastname']}',
              email='{$_POST['email']}',
              contact='{$_POST['contact']}'
              WHERE firstname='{$_POST['firstname']}'";
    mysqli_query($link, $query);
    echo "<script>window.location.href = window.location.href;</script>";
}

// --- DELETE ---
if (isset($_POST["delete"])) {
    $query = "DELETE FROM users WHERE firstname='{$_POST['firstname']}'";
    mysqli_query($link, $query);
    echo "<script>window.location.href = window.location.href;</script>";
}
?>

</body>
</html>
