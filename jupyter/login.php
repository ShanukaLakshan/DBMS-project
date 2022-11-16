<?php
include('user_config.php');
//include('db_connector.php');
$username = "" . $_POST['uname'];
$userpassword = "" . $_POST['pwd'];

try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
} catch (Exception $e) {
    echo $e;
    exit();
}
$check=$conn->prepare("select * from user where user_name=? and password=?");
$check->bind_param("ss", $username, $userpassword);
$check->execute();
$result = $check->get_result();
$arr=mysqli_fetch_array($result);
// $res = mysqli_query($conn,"select * from user where user_name='$username'and password='$userpassword'");
// $result=mysqli_fetch_array($res);

if($arr)
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