<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lesson 2b - PHP Operators</title>
</head>
<body>
    <h1>This is my first PHP page</h1>

    <?php
    // Lấy giá trị từ URL: ?x=5&y=8
    $x = isset($_GET["x"]) ? (int)$_GET["x"] : 5;
    $y = isset($_GET["y"]) ? (int)$_GET["y"] : 8;

    echo "<h2>Arithmetic Operators</h2>";
    echo "x = $x, y = $y <br/><br/>";
    echo "x + y = " . ($x + $y) . "<br/>";
    echo "x - y = " . ($x - $y) . "<br/>";
    echo "x * y = " . ($x * $y) . "<br/>";
    if ($y != 0) {
        echo "x / y = " . ($x / $y) . "<br/>";
        echo "x % y = " . ($x % $y) . "<br/>";
    } else {
        echo "x / y = lỗi (chia cho 0) <br/>";
        echo "x % y = lỗi (chia cho 0) <br/>";
    }

    echo "<h2>Comparison Operators</h2>";
    echo "x == y : " . ($x == $y ? "true" : "false") . "<br/>";
    echo "x != y : " . ($x != $y ? "true" : "false") . "<br/>";
    echo "x > y  : " . ($x > $y ? "true" : "false") . "<br/>";
    echo "x < y  : " . ($x < $y ? "true" : "false") . "<br/>";
    echo "x >= y : " . ($x >= $y ? "true" : "false") . "<br/>";
    echo "x <= y : " . ($x <= $y ? "true" : "false") . "<br/>";
    ?>
</body>
</html>
