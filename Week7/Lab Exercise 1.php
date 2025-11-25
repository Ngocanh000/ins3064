//EX1:
<?php
setcookie("username", "Ngoc Anh", time() + 3600);
echo "Cookie 'username' has been set!";
?>
//EX2:
<?php
if (isset($_COOKIE['username'])) {
    $cookieValue = $_COOKIE['username'];
    echo "Value of cookie 'username': " . $cookieValue;
} else {
    echo "Cookie 'username' not found!";
}
?>
//EX3:
<?php
$cookieName = "username";

setcookie($cookieName,"",time()-3600);
echo "Cookie 'username' has been deleted!";
?>
//EX4:
<?php
session_save_path ('i:/custom/');
session_start();

$_SESSION['userid']= 22071009;
echo "Session variable 'userid' has been set with the value 22071009!";
?>
//EX5:
<?php
session_save_path ('i:/custom/');
session_start();
if (isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
    echo "Value of session variable 'userid': " . $userid;
} else{
    echo "Session variable 'userid' not found!";
}
?>
//EX6:
<?php
session_save_path ('i:/custom/');
session_start();

$_SESSION = [];
session_destroy();
echo "Session destroyed.All session variable have been unset.";
?>
//EX7:
<?php
$cookieName = "username";
$cookieValue = "Ngoc Anh";
$expirationTime = time()+3600;
$secureOnly = true;

setcookie($cookieName, $cookieValue, $expirationTime,"/","",$secureOnly,true);
echo "Secure cookie 'username' has been set!";
?>
//EX8:
<?php
$cookieName = "visited";
if(isset($_COOKIE[$cookieName])){
    echo "Welcome back!You have visited before.";
} else {
    echo"Welcome!This is your first visit";
}
?> 
<?php
function checkVisited() {
    $name = "visited";

    if (isset($_COOKIE[$name])) {
        return "Welcome back! You have visited before.";
    } else {
        setcookie($name, "yes", time() + 3600, "/");
        return "Hello new visitor! Cookie has been set.";
    }
}

echo checkVisited();
?>
<?php
$cookie = "visited";

if (isset($_COOKIE[$cookie])) {
    echo "<h2>Welcome back! 😊</h2>";
    echo "<p>Good to see you again!</p>";
} else {
    echo "<h2>Hello new visitor! 👋</h2>";
    echo "<p>This is your first time here!</p>";

    setcookie($cookie, "yes", time() + 3600, "/");
}
?>
//EX9:


