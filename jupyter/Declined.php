<?php
include_once 'admin_config.php';

$conn = mysqli_connect($sname, $uname, $password, $db_name);
$us_name = $_GET['get_username'];
$date = (new DateTime("now", new DateTimeZone('Asia/Colombo') ))->format('Y-m-d');
mysqli_query($conn, "UPDATE leave_requests SET status='Declined' , date_moderated='$date' WHERE id='" . $_GET['id'] . "' and date_of_leave='" . $_GET['date'] . "'");
header("Location: approve_leaves.php");
?>