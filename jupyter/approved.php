<?php
include_once 'admin_config.php';

$conn = mysqli_connect($sname, $uname, $password, $db_name);
$us_name = $_GET['get_username'];
mysqli_query($conn, "UPDATE leave_request SET status='approved' WHERE id='" . $_GET['id'] . "' and date='" . $_GET['date'] . "'");
header("Location: approve_leaves.php?get_username=$us_name");
