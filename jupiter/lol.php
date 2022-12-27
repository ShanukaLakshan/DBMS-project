<?php

include('admin_config.php');
$conn = mysqli_connect($sname, $uname, $password, $db_name);

$legend = false;
if(empty($_POST['dpt']) && empty($_POST['datef']) && empty($_POST['datet'])){
  $title = 'Leaves by Departments';
  $chart_type = 'bar';
  $sql1 = "SELECT name,total_leaves from department left outer join (select count(id) as total_leaves,dept_id from leave_requests left outer join employment using(id) where status='approved' group by dept_id) t2 on department.id=t2.dept_id order by total_leaves ASC;";

$result1 = mysqli_query($conn,$sql1);

$data = array();
$datax=array();
$datay=array();
foreach ($result1 as $row) {
  array_push($datax,$row['name']);
  if ($row['total_leaves'] == Null) {
    array_push($datay,'0');
  }
  else {
    array_push($datay,$row['total_leaves']);
  }
}
}
if(!empty($_POST['dpt']) && empty($_POST['datef']) && empty($_POST['datet'])){
  $dept_id=$_POST['dpt'];
  $dept_query = "SELECT * FROM department where id = '$dept_id';";
  $dept_result = $conn->query($dept_query);
  $dept_name = mysqli_fetch_all($dept_result, MYSQLI_ASSOC);
  $title = 'Leaves by '.$dept_name[0]['name'].' Department';
  $chart_type = 'doughnut';
  $legend = true;
  $sql1 = "SELECT total_leaves,name from leave_type left outer join (select count(id) as total_leaves,type_id,dept_id from leave_requests left outer join employment using(id) where dept_id='$dept_id' and status='approved' group by (type_id)) t2 on leave_type.type_id=t2.type_id order by total_leaves ASC";

$result1 = mysqli_query($conn,$sql1);

$data = array();
$datax=array();
$datay=array();
foreach ($result1 as $row) {
  array_push($datax,$row['name']);
  if ($row['total_leaves'] == Null) {
    array_push($datay,'0');
  }
  else {
    array_push($datay,$row['total_leaves']);
  }
}
}
if(empty($_POST['dpt']) && !empty($_POST['datef'])){
  $chart_type = 'bar';
  $date_f=$_POST['datef'];
  $date_t=$_POST['datet'];
  if ($date_t == Null) {
    $title = 'Leaves by Departments from '.$_POST['datef'];
    $sql1 = "SELECT name,total_leaves from department left outer join (select count(id) as total_leaves,dept_id from leave_requests left outer join employment using(id) where status='approved' and date_of_leave BETWEEN '$date_f' and CURRENT_DATE() group by dept_id) t2 on department.id=t2.dept_id order by total_leaves ASC;";
  }
  else{
    $title = 'Leaves by Departments from '.$_POST['datef'].' to '.$_POST['datet'];
    $sql1 = "SELECT name,total_leaves from department left outer join (select count(id) as total_leaves,dept_id from leave_requests left outer join employment using(id) where status='approved' and date_of_leave BETWEEN '$date_f' and '$date_t' group by dept_id) t2 on department.id=t2.dept_id order by total_leaves ASC;";
  }

$result1 = mysqli_query($conn,$sql1);

$data = array();
$datax=array();
$datay=array();
foreach ($result1 as $row) {
  array_push($datax,$row['name']);
  if ($row['total_leaves'] == Null) {
    array_push($datay,'0');
  }
  else {
    array_push($datay,$row['total_leaves']);
  }
}
}
if(!empty($_POST['dpt']) && !empty($_POST['datef'])){
  $dept_id=$_POST['dpt'];
  $date_f=$_POST['datef'];
  $date_t=$_POST['datet'];
  $dept_query = "SELECT * FROM department where id = '$dept_id';";
  $dept_result = $conn->query($dept_query);
  $dept_name = mysqli_fetch_all($dept_result, MYSQLI_ASSOC);
  $chart_type = 'doughnut';
  $legend = true;
  if ($date_t == Null) {
    $title = 'Leaves by '.$dept_name[0]['name'].' Department from '.$_POST['datef'];
    $sql1 = "SELECT total_leaves,name from leave_type left outer join (select count(id) as total_leaves,type_id,dept_id from leave_requests left outer join employment using(id) where dept_id='$dept_id' and status='approved' BETWEEN '$date_f' and CURRENT_DATE() group by (type_id)) t2 on leave_type.type_id=t2.type_id order by total_leaves ASC";
  }
  else{
    $title = 'Leaves by '.$dept_name[0]['name'].' Department from '.$_POST['datef'].' to '.$_POST['datet'];
    $sql1 = "SELECT total_leaves,name from leave_type left outer join (select count(id) as total_leaves,type_id,dept_id from leave_requests left outer join employment using(id) where dept_id='$dept_id' and status='approved' BETWEEN '$date_f' and '$date_t' group by (type_id)) t2 on leave_type.type_id=t2.type_id order by total_leaves ASC";
  }

  $result1 = mysqli_query($conn,$sql1);

  $data = array();
  $datax=array();
  $datay=array();
  foreach ($result1 as $row) {
    array_push($datax,$row['name']);
    if ($row['total_leaves'] == Null) {
      array_push($datay,'0');
    }
    else {
      array_push($datay,$row['total_leaves']);
    }
  }
}
?>




<!DOCTYPE html>
<html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />

<body>

  <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="row align-content-center justify-content-center">
      <div class="col">
          <div class="card shadow-lg">
            <div class="card-header">
              <h4 class="text-center mt-3"><?php echo $title ?></h4>
            </div>
            <div class="card-body">
              <canvas id="myChart" style="height:400px;width:1000px"></canvas>
            </div>
            <form action='' method=POST style="margin-bottom: 30px;">
            <div class="row justify-content-center mt-3">
              <div class="col-auto">
                <select class="form-select" name="dpt">
                  <option value="">Department</option>
                  <?php
                  $query = "SELECT * FROM department ORDER BY name ASC";
                  $result = $conn->query($query);
                  if ($result->num_rows > 0) {
                  $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                  }
                  foreach ($options as $option) {
                  ?>
                  <option value="<?php echo $option['id']; ?>">
                    <?php echo $option['name']; ?>
                  </option>
                  <?php
                  }
                  ?>
                </select>
              </div>


              <div class="col-auto">
                    <input type="date" style="margin-top: 1px" class="form-control" name="datef"/>
              </div>
              <div class="col-auto">
                    <input type="date" style="margin-top: 1px" class="form-control" name="datet"/>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-auto mt-3">
                <input class="btn btn-primary" type="submit" value="Filter" />
              </div>
            </div>
          </form>
          </div>
      </div>
    </div>
  </div>
  
  <script>

var xValues = <?php echo json_encode($datax); ?>;
var yValues = <?php echo json_encode($datay); ?>;
new Chart("myChart", {
  type: <?php echo json_encode($chart_type); ?>,
  data: {
    labels: xValues,
    datasets: [{
      data: yValues,
      backgroundColor: ['#196F3D','#2ECC71','#82E0AA','#F4D03F','#F39C12','#E67E22','#FF5733','#E74C3C'],
      hoverOffset: 4,
    }]
  },
  options: {
    legend: { display: <?php echo json_encode($legend); ?> }
  }
});
</script>
</body>

</html>