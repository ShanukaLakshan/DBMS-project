<?php
include 'user_config.php';
echo "Logout clicked";
$username = $_COOKIE['uname'];
$userpassword = $_COOKIE['pass'];

$conn = mysqli_connect($sname, $uname, $password, $db_name);
$res2 = mysqli_query($conn, "update user set login_status='0' where user_name='$username'and password='$userpassword'");
setcookie("uname", "", time() - 1);
setcookie("pass", "", time() - 1);
header("location:index.php");
