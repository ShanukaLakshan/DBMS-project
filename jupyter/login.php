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
// $check=$conn->prepare("select * from user where user_name=? and password=?");
// $check->bind_param("ss", $username, md5($userpassword.$username));
// $check->execute();
// $result = $check->get_result();
// $arr=mysqli_fetch_array($result);

// $res = mysqli_query($conn,"select * from user where user_name='$username'and password='$userpassword'");
// $result=mysqli_fetch_array($res);

// user authentication
$check=$conn->prepare("SELECT jupiter.auth(?, ?) AS result");
$check->bind_param("ss", $username, md5($userpassword.$username));
$check->execute();
$result = $check->get_result();
$row = $result->fetch_assoc(); 
$verify = $row['result'];

if($verify)
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