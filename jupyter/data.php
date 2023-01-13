<?php
// header('Content-Type: application/json');

include('admin_config.php');
$conn = mysqli_connect($sname, $uname, $password, $db_name);

$sql1 = "select name,total_leaves from department left outer join (select count(id) as total_leaves,dept_id from leave_requests left outer join employment using(id) where status='declined' group by dept_id) t2 on department.id=t2.dept_id order by name asc;";

$result = mysqli_query($conn,$sql1);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}
mysqli_close($conn);

echo json_encode($data);
header("Location:leave_report.html")
?>