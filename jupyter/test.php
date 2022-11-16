<?php

include('admin_config.php');
$conn = mysqli_connect($sname, $uname, $password, $db_name);

$sql1 = "select name,total_leaves from department left outer join (select count(id) as total_leaves,dept_id from leave_requests left outer join employment using(id)  group by dept_id) t2 on department.id=t2.dept_id order by name asc;";

$result = mysqli_query($conn,$sql1);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}
mysqli_close($conn);


?>




<!DOCTYPE html>
<html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<body>

<canvas id="myChart" style="width:100%;max-width:600px"></canvas>

<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["red", "green","blue","orange","brown"];

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "World Wine Production 2018"
    }
  }
});
</script>

</body>
</html>
