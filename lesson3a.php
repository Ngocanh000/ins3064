<?php
// Ví dụ function cộng 2 số (comment lại, không dùng)
// function sum($a, $b) {
//     return $a + $b;
// }
// $sum = sum(4, 5);
// echo("Tong cua 4 va 5 la " . $sum);

// Hàm hoán đổi 2 số
function swap(&$x, &$y) {
    $temp = $x;
    $x = $y;
    $y = $temp;
}

$a = 4;
$b = 6;
$c = 5;

echo ("Number a is " . $a);
echo ("<br>");
echo ("Number b is " . $b);

swap($a, $b);

echo "<br>After swap:";
echo "<br>Number a is " . $a;
echo "<br>Number b is " . $b;
?>
