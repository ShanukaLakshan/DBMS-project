<?php
if(!isset($_COOKIE["uname"]))// $_COOKIE is a variable and login is a cookie name 

	header("location:login.php"); 

?>
<?php
    $username=$_COOKIE['uname'];
    $userpassword=$_COOKIE['pass'];

include('user_config.php');
include('db_connector.php');

try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
} catch (Exception $e) {
    echo "<p style='color:red;'>Database Connection Failed !</p>";
    exit();
}
?>

<?php
if(empty($_POST['xdate'])){
    header("location:leaveform.php?date=1");
}
if(preg_match("/\b(Leave)\b/",$_POST['xleave_type'] )){
    header("location:leaveform.php?err=1");
}
?>

<?php
$date = (new DateTime("now", new DateTimeZone('Asia/Colombo') ))->format('Y-m-d');
$sql2 = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$username'");
$row2 = mysqli_fetch_array($sql2);
$id=$row2['id'];
$row=mysqli_query($conn,"SELECT * FROM leave_requests WHERE id = '$id'  AND status in ('approved','Pending') AND date_of_leave = '".$_POST['xdate']."'");
if(0<(mysqli_num_rows($row))){
    header("location:leaveform.php?err=1");
}
$status='Pending';
$request=$conn->prepare("INSERT INTO leave_requests (id,type_id,date_of_leave,date_requested,status) VALUES (?,?,?,?,?)");
$request->bind_param("issss", $id, $_POST['xleave_type'], $_POST['xdate'], $date, $status);
try{
    $conn->begin_transaction();
    $request->execute();
}
catch(Exception $e){
    $conn->rollback();
    echo "Error: " . $e->getMessage();
    header("location:leaveform.php?errs=1");
    exit();
}
$conn->commit();
header("Location: homepage.php");
?>