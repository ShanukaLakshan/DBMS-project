<?php
include('user_config.php');
//include('db_connector.php');
$username = "" . $_POST['uname'];
$userpassword = "" . $_POST['pwd'];

/* 
$plaintext_password = $userpassword;

$hash = password_hash($plaintext_password, PASSWORD_DEFAULT);

$verify = password_verify($plaintext_password, $hash);

if ($verify) {
  echo 'Password Verified!';
} else {
  echo 'Incorrect Password!';
}
*/

try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
} catch (Exception $e) {
    echo $e;
    exit();
}

$res = mysqli_query($conn, "select * from user where user_name='$username'and password='$userpassword'");
$result = mysqli_fetch_array($res);

if ($result) {

    // if user name and password is matched

    $res1 = mysqli_query($conn, "select * from user where user_name='$username'and password='$userpassword' and login_status='0'");
    $result1 = mysqli_fetch_array($res1);

    if (!$result1) {
        header("location:index.php?err=2");
    } else {
        // need to change 0 to 1
        $res2 = mysqli_query($conn, "update user set login_status='1' where user_name='$username'and password='$userpassword'");
        setcookie("uname", $username, time() + 3600);
        setcookie('pass', $userpassword, time() + 3600);
        header("location:homepage.php");
    }
} else {
    header("location:index.php?err=1");
}
