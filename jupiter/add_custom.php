<?php
include('user_config.php');
//include('db_connector.php');

try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
} catch (Exception $e) {
    echo $e;
    exit();
}
$attr_name=$_POST['name'];
$custom=$conn->prepare("INSERT INTO custom_attribute VALUES (?)");
$custom->bind_param("s", $attr_name);
$column="ALTER TABLE employee ADD ".$attr_name." VARCHAR(30)";
try{
    $conn->begin_transaction();
    $custom->execute();
    $conn->query($column);
}
catch(Exception $e){
    $conn->rollback();
    header("Location: ./custom_attribute.php?a=1");
    exit();
}
$conn->commit();
header("Location: ./custom_attribute.php?d=1")
?>