<?php
include('user_config.php');
include('db_connector.php');
$username = "" . $_POST['uname'];
$userpassword = "" . $_POST['pwd'];

try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
} catch (Exception $e) {
    echo "<p style='color:red;'>Database Connection Failed !</p>";
    exit();
}

$res = mysqli_query($conn,"select* from user where user_name='$username'and password='$userpassword'");
$result=mysqli_fetch_array($res);

if($result)
{
	setcookie("uname",$username,time()+3600);// second on page time 
    setcookie('pass',$userpassword,time()+3600);
    header("location:homepage.php");
}
else
{
	header("location:index.php?err=1");
	
}
?>