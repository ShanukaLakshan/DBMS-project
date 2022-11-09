<?php

// $sname = "localhost";
// $uname = "" . $_POST['uname'];
// $password = "" . $_POST['pwd'];
// $db_name = "jupyter";

include('admin_config.php');

$conn = mysqli_connect($sname, $uname, $password, $db_name);
$name = $_POST['xxfname'] . $_POST['xxlname'];
$id = 88;
$gender = $_POST['xxgender'];
$mobile = '0771231231';
$email = $_POST['xxemail'];
$bdate = $_POST['xxbdate'];
$marital = 'married';
$addresline1 = 'addresline1';
$addresline2 = 'addresline2';
$city = $_POST['xxcity'];
$province = $_POST['xxprovince'];
$zip = $_POST['xxzip'];
// $jtitle = $_POST['xxjtitle'];
$jtitle = 'hr-manager';
$dpt = $_POST['xxdpt'];
// $paygrade = $_POST['xxpaygrade'];
$paygrade = 3;
$status = $_POST['xxstatus'];
// $bnkname = $_POST['xxbnkname'];
$bnkname = "BOC";
$bncname = $_POST['xxbncname'];
$accn = $_POST['xxaccn'];

$sql1 = "INSERT INTO employee VALUES ('$name','$id','$gender','$mobile','$email','$bdate','$marital')";
$sql2 = "INSERT INTO address VALUES ('$id','$addresline1','$addresline2','$province','$city','$zip')";
$sql3 = "INSERT INTO employment VALUES ('$id','$jtitle','$paygrade','$status','$dpt')";
$sql4 = "INSERT INTO bank_details VALUES ('$id','$bnkname','$bncname','$accn')";

if (!$conn) {
    echo "Connection Failed!";
    exit();
}
if ($conn->query($sql1) === TRUE) {
    echo "\nNew employee record created successfully\n";
} else {
    echo "Error: ";
}
if ($conn->query($sql2) === TRUE) {
    echo "\nNew address record created successfully\n";
} else {
    echo "Error: ";
}
if ($conn->query($sql3) === TRUE) {
    echo "\nNew employment record created successfully\n";
} else {
    echo "Error: ";
}
if ($conn->query($sql4) === TRUE) {
    echo "\nNew bank_details record created successfully\n";
} else {
    echo "Error: ";
}





// exit();
