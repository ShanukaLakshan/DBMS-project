<?php
include('user_config.php');
include('db_connector.php');

try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
} catch (Exception $e) {
    echo "<p style='color:red;'>Database Connection Failed !</p>";
    exit();
}


if(!empty($_POST['id'])){
    $user_id->bind_param("i", $_POST['id']);
    $user_id->execute();
    $result = $user_id->get_result();
    $emp_id->bind_param("i", $_POST['id']);
    $emp_id->execute();
    $result2 = $emp_id->get_result();
    // $row=mysqli_query($conn,"SELECT * FROM user WHERE id=".$_POST['id']."");
    // $row2=mysqli_query($conn,"SELECT * FROM employee WHERE id=".$_POST['id']."");
    if((mysqli_num_rows($result)>0) || (mysqli_num_rows($result2)==0)){
      header("location:new_user.php?err=1");
  }
  }
$user_user=$conn->prepare("SELECT * FROM user WHERE user_name=?");
$user_user->bind_param("s", $_POST['uname']);
$user_user->execute();
$result = $user_user->get_result();
if(0<(mysqli_num_rows($result))){
    header("location:add_user.php?user=1");
    exit();}
if(!empty($_POST['pass-1'])){
if((strcmp($_POST['pass-1'],$_POST['pass-2']) )){
    header("location:add_user.php?pass=1");
    exit();
}
if(strlen($_POST['pass-1'])>0 && strlen($_POST['pass-1'])<8){
    header("location:add_user.php?passl=1");
    exit();
}
}
$uname=$_POST['uname'];
$pass=$_POST['pass-1'];
$id=$_POST['id'];

$us='user';
$filename='default.jpg';
$user=$conn->prepare("INSERT INTO user (user_name,id,password,user_type,img_name) VALUES (?,?,?,?,?)");
$user->bind_param("sisss", $uname, $id, $pass, $us, $filename);
try{
    $conn->begin_transaction();
    $user->execute();
}
catch(Exception $e){
    $conn->rollback();
    echo "Error: " . $e->getMessage();
    setcookie("id","",time()-1);
    header("location:index.php?cerr=1");
    exit();
}
$conn->commit();
if(!empty($_FILES["profileImage"]["tmp_name"])){
    $image=addslashes(file_get_contents($_FILES["profileImage"]["tmp_name"])); 
    $jpgname=time().'-'.$id;
    $sql = "UPDATE user SET img_data='$image', img_name='$jpgname' WHERE id = '$id'";
                if (mysqli_query($conn, $sql)) {
                    $msg = "Image uploaded and saved in the Database";
                    $msg_class = "alert-success";
                    setcookie("id","",time()-1);
                    header("location:index.php?c=1");
                } else {
                    $msg = "There was an error in the database";
                    $msg_class = "alert-danger";
                    setcookie("id","",time()-1);
                    header("location:index.php?perr=1");
                }
}
setcookie("id","",time()-1);
header("location:index.php?c=1");

// if ($conn->query("INSERT INTO user (user_name,id,password,user_type,img_name) VALUES ('$uname','$id','$pass','user','default.jpg')") === TRUE) {
//     header("location:index.php?c=1");
// } else {
//     echo "Error: ";
// }
?>