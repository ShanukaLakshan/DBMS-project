<?php 

if(!isset($_COOKIE["uname"]))// $_COOKIE is a variable and login is a cookie name 

	header("location:login.php"); 

?>
<?php
    $username=$_COOKIE['uname'];
    $userpassword=$_COOKIE['pass'];

include('admin_config.php');
include('db_connector.php');

try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
} catch (Exception $e) {
    echo "<p style='color:red;'>Database Connection Failed !</p>";
    exit();
}

?>

<?php
$msg = "";
$msg_class = "";

$sql2 = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$username'");
$row = mysqli_fetch_array($sql2);
$id=$row['id'];
$sql2 = "SELECT * FROM user WHERE user_name = '".$_POST['uname']."'";
$row2 = mysqli_query($conn, $sql2);
if(0!=mysqli_num_rows($row2)){
    header("location:account_details.php?user=1");
    exit();}
if(!empty($_POST['pass-1'])){
    if((strcmp($_POST['pass'],$row['password'] ))){
        header("location:account_details.php?error=1");
        exit();
    }
    if((strcmp($_POST['pass-1'],$_POST['pass-2']) )){
        header("location:account_details.php?pass=1");
        exit();
    }
    if(strlen($_POST['pass-1'])>0 && strlen($_POST['pass-1'])<8){
        header("location:account_details.php?passl=1");
        exit();
    }
}

if (isset($_POST['save_profile']) && !empty($_FILES["profileImage"]["name"])) {
    // for the database
    $profileImageName = time() . '-' . $_FILES["profileImage"]["name"];
    $image=addslashes(file_get_contents($_FILES["profileImage"]["tmp_name"])); 
    // For image upload
    $target_dir = "images/";
    $target_file = $target_dir . basename($profileImageName);
    // VALIDATION
    // validate image size. Size is calculated in Bytes
    if ($_FILES['profileImage']['size'] > 500000) {
        $msg = "Image size should not be greated than 200Kb";
        $msg_class = "alert-danger";
    }
    // check if file exists
    if (file_exists($target_file)) {
        $msg = "File already exists";
        $msg_class = "alert-danger";
    }
    $jpgname=''.$username.'.jpeg';
    // Upload image only if no errors
    if (empty($error)) {
        if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
            $sql = "UPDATE user SET img_data='$image', img_name='$jpgname' WHERE user_name = '$username'";
            if (mysqli_query($conn, $sql)) {
                $msg = "Image uploaded and saved in the Database";
                $msg_class = "alert-success";
            } else {
                $msg = "There was an error in the database";
                $msg_class = "alert-danger";
            }
        } else {
            $error = "There was an erro uploading the file";
            $msg = "alert-danger";
        }
    }
    header("location:homepage.php?c=1");
    exit();
}

elseif(!empty($_POST['uname'])){
    $sql = "UPDATE user SET user_name='".$_POST['uname']."' WHERE id = '$id'";
    setcookie("uname",$_POST['uname'],time()+3600);
    mysqli_query($conn, $sql);
    header("location:homepage.php?c=1");
    exit();
}
elseif(!empty($_POST['pass-1'])){
    $sql = "UPDATE user SET password='".$_POST['pass-1']."' WHERE id = '$id'";
    setcookie('pass',$_POST['pass-1'],time()+3600);
    mysqli_query($conn, $sql);
    header("location:homepage.php?c=1");
    exit();
}
else{
    header("location:account_details.php");
    exit();
}
