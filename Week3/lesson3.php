<?php
// Hàm tìm số nhỏ nhất trong 3 số
function minOfThree($a, $b, $c) {
    $min = $a;
    if ($b < $min) {
        $min = $b;
    }
    if ($c < $min) {
        $min = $c;
    }
    return $min;
}

$a = 4;
$b = 6;
$c = 5;

echo "Number a is " . $a . "<br>";
echo "Number b is " . $b . "<br>";
echo "Number c is " . $c . "<br>";

echo "The smallest number is: " . minOfThree($a, $b, $c);
?>
