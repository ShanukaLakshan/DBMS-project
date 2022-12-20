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
$custom=$conn->prepare("INSERT INTO custom_attribute (name) VALUES (?)");
$custom->bind_param("s", $attr_name);
$row2 = mysqli_fetch_array(mysqli_query($conn, "select * from custom_attribute order by attr_id desc limit 1"));

$id='custom_'.($row2['attr_id']+1);
$column="ALTER TABLE employee ADD $id VARCHAR(30)";
try{
    $conn->begin_transaction();
    $custom->execute();
    $conn->query($column);
}
catch(Exception $e){
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
$conn->commit();
header("Location: ./custom_attribute.php?d=1")
?>