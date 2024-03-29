<<<<<<< Updated upstream:jupyter/leaveform.php

<?php 

if(!isset($_COOKIE["uname"]))// $_COOKIE is a variable and login is a cookie name 

	header("location:login.php"); 

?>
<?php 
if(isset($_REQUEST["date"]))
	$msg="Enter the date";
?>
<?php 
if(isset($_REQUEST["err"]))
	$msg="Leave already requested";
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

try {
    $sql2 = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$username' AND password = '$userpassword'");
    $row2 = mysqli_fetch_array($sql2);
    $sql1 = mysqli_query($conn, "SELECT * FROM employee WHERE id in (SELECT id FROM user WHERE user_name = '$username' AND password = '$userpassword')");
    $row = mysqli_fetch_array($sql1);
    $id=$row2['id'];
    $get_leaves = "select id FROM leave_requests WHERE id in (SELECT id FROM supervisor where supervisor_id = '$id') and status='pending'";
    $leave = mysqli_query($conn, $get_leaves);
    
    $sql3 = mysqli_query($conn,"SELECT * FROM employment WHERE id='$id'");
    $row4 = mysqli_fetch_array($sql3);

    $sql4 = mysqli_query($conn,"SELECT * FROM address WHERE id='$id'");
    $row5 = mysqli_fetch_array($sql4);

    $sql5 = mysqli_query($conn,"SELECT count(id) as count FROM leave_requests WHERE id='$id' and status='approved' and type='casual'");
    $casualc=mysqli_fetch_array($sql5);

    $sql6 = mysqli_query($conn,"SELECT count(id) as count FROM leave_requests WHERE id='$id' and status='approved' and type='annual'");
    $annualc=mysqli_fetch_array($sql6);

    $sql7 = mysqli_query($conn,"SELECT count(id) as count FROM leave_requests WHERE id='$id' and status='approved' and type='maternity'");
    $maternityc=mysqli_fetch_array($sql7);

    $sql8 = mysqli_query($conn,"SELECT count(id) as count FROM leave_requests WHERE id='$id' and status='approved' and type='no_pay'");
    $nopayc=mysqli_fetch_array($sql8);

    $sql9 = mysqli_query($conn,"SELECT * FROM leave_detail WHERE job_title='$row4[job_title]' and pay_grade='$row4[pay_grade]'");
    $leaves=mysqli_fetch_array($sql9);
} catch (Exception $e) {
    echo "<p style='color:red;'>Username or Password is incorrect !</p>";
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <title> Jupiter - Leaveform</title>
  <link rel="icon" type="image/x-icon" href="./img/favicon.png" />
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
  body {
    background-color: #635666;
  }

  /* The side navigation menu */
  .sidebar {
    margin: 0;
    padding: 0;
    width: 100px;
    background-color: #ECE5C7;
    position: fixed;
    height: 100%;
    overflow: auto;
    text-align: center;
    justify-content: center;
  }

  /* Sidebar links */
  .sidebar a {
    display: flex;
    color: black;
    padding: 16px;
    text-decoration: none;
    height: 82px;
    text-align: center;
    justify-content: center;

  }

  /* Active/current link */
  .sidebar a.active {
    background-color: #354259;
    color: rgb(255, 255, 255);
  }

  /* Links on mouse-over */
  .sidebar a:hover:not(.active) {
    background-color: #555;
    color: white;
  }

  /* Page content. The value of the margin-left property should match the value of the sidebar's width property */
  div.content {
    margin-left: 90px;
    padding: 1px 16px;
    height: auto;
  }

  .container-fluid {
    margin-right: 100px;
    max-width: 1900px;
  }

  /* On screens that are less than 700px wide, make the sidebar into a topbar */
  @media screen and (max-width: 700px) {
    .sidebar {
      width: 100%;
      height: auto;
      position: relative;
    }

    .sidebar a {
      float: right;
    }

    div.content {
      margin-left: 0;
    }
  }

  /* On screens that are less than 400px, display the bar vertically, instead of horizontally */
  @media screen and (max-width: 400px) {
    .sidebar a {
      text-align: end;
      float: none;
    }
  }

  /* Dropdown Button */
  .dropbtn {
    background-color: #3e8e4100;
    color: black;
    padding: 0px;
    width: fit-content;
    max-height: 30px;
    font-size: 16px;
    align-self: flex-end;
    border: none;
  }

  /* The container <div> - needed to position the dropdown content */
  .dropdown {
    position: relative;
    display: inline-block;
  }

  /* Dropdown Content (Hidden by Default) */
  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f186;
    min-width: 145px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0);
    z-index: 1;
    left: 0;
  }

  /* Links inside the dropdown */
  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  /* Change color of dropdown links on hover */
  .dropdown-content a:hover {
    background-color: rgb(221, 221, 221);
  }

  /* Show the dropdown menu on hover */
  .dropdown:hover .dropdown-content {
    display: block;
  }

  /* Change the background color of the dropdown button when the dropdown content is shown */
  .dropdown:hover .dropbtn {
    background-color: #3e8e4100;
  }

  .progress-bar-warning {
    background-color: #635666;

  }

  .btn-sq {
    border-radius: 0px;
    background-color: #CDC2AE;
    height: 82px !important;
    width: 100px !important;
  }

  .btn:hover {
    background-color: #354259;
    border-radius: 0px;
    color: white
  }

  .btn-primary {
    background-color: #635666;
    color: white;
    border-color: #635666;
  }
  .btn-primary:hover {
    background-color: #8d7992;
    border-radius:10%;
    border-color: #8d7992;
    color: white
  }
</style>

<body>
  <div class="sidebar">
    <a href="../jupyter/homepage.php">Home</a>
    <?php if ($row2['user_type'] === 'admin') { ?>
    <a href="../jupyter/review_employee.php">Review Employees</a>
    <?php } else { ?>
    <a href="#" style="display: none;">Review Employees</a>
    <?php } ?>
    <?php if ($row4['job_title'] === 'HR Manager') { ?>
      <a href="../jupyter/add_new_employee.php">Add New Employee</a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Add New Employee</a>
  <?php } ?>
    <a class="active" href="../jupyter/leaveform.php">Request a Leave</a>
    <a href="../jupyter/approve_leaves.php">Pending Approvals</a>
    <span class="position-absolute top-70 start-90 translate-middle badge rounded-pill bg-danger">
      <?php echo "" . mysqli_num_rows($leave); ?>

  </div>
  <div class="content">
    <div class="row col-lg-15 " style="background-color:#354259">
      <div class="col">
        <a href='./homepage.php'>
          <img  class="border-dark " src="./img/jupiter_logo.png"
            style="width:250px;margin-bottom: 5px;margin-left: 10px;">
          </a>
      </div>
      <div class="col-lg-6 align-self-center text-center">
        <h4 style="color:rgb(255, 255, 255)">Jupiter Employee Portal</h4>
      </div>
      <div class="col-sm-3 align-self-lg-center d-flex justify-content-end">
        <div class="row mx-0 text-end">
          <div class="col-auto text-end">
            <?php
                          $sql3 = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");
                          $row3 = mysqli_fetch_array($sql3);
                          $name = $row2['img_name'];
                          $stmt = $pdo->prepare("SELECT `img_data` FROM `user` WHERE `img_name`=?");
                          $stmt->execute([$name]);
                          $img = $stmt->fetch();
                          $img = $img["img_data"];
                          $img = base64_encode($img);
                          $ext = pathinfo($name, PATHINFO_EXTENSION);
                          if (!empty($img)){
                            echo "<img src='data:image/" . $ext . ";base64," . $img . "' height='auto' width='30px' class='rounded-circle' alt='...'/>";
                          }
                          else{
                            echo "<img src='./img/user-default.png' height='auto' width='30px' class='rounded-circle' alt='...'/>";
                          }                          ?>

          </div>
          <div class="col-lg-auto text-end align-content-end" style="margin-left:-4%;">
            <div class="dropdown align-self-end" style="float:right">
              <button class="dropbtn align-self-end">
                <p style="color:white">
                  <?php echo $row['name'] ?> &nbsp<i class="fa fa-caret-down"></i>
                </p>
              </button>
              <div class="dropdown-content" style="left:0px">
                <a href="./account_details.php">Account details</a>
                <a href="../jupyter/logout.php">Logout</a>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    <div class="container-fluid mx-0">
      <div class="card" style="background-color: #eeedde78;padding: 2%;min-height: 85vh;margin-top: 1%;">
        <div class="row justify-content-center">
          <div class="col-auto">
            <div class="card" style="background-color: #EEEDDE;min-height:80vh;">
              <div class="card-header">
                <p class="fw-bold" style="font-size:large">Leave details</p>
              </div>
              <div class="card-body">
                <form method="POST" action="leave_request.php">
                  <div class="md-3">
                    <div class="row align-self-center">
                      <div class="col">
                        <p style="margin: 0" style="font-size: 3px">Name</p>
                        <input type="text" style="margin-top: 1px" class="form-control" name="xuname"
                          value="<?php echo $row['name'] ?>" placeholder="<?php $row['id'] ?>" readonly />
                      </div>
                      <div class="col">
                        <p style="margin: 0" style="font-size: 3px">ID</p>
                        <input type="text" style="margin-top: 1px" class="form-control" name="xid"
                          value="<?php echo $row['id'] ?>" placeholder="<?php echo $row['id'] ?>" readonly />
                      </div>
                    </div>
                    <p style="margin: 0" style="font-size: 3px">Date</p>
                    <input type="date" style="margin-top: 1px" class="form-control" name="xdate" required/>
                  </div>
                  <div>
                    <p style="margin: 0" style="font-size: 3px">
                      Select Leave Type
                    </p>
                    <select class="form-select" name="xleave_type" required>
                      <option value="">Leave Type</option>
                      <?php
                                            $query = "show columns from leave_detail where Field not in ('pay_grade','job_title')";
                                            $result = mysqli_query($conn, $query);
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo "<option value='" . $row['Field'] . "'>" . $row['Field'] . "</option>";
                                            }
                                            ?>
                    </select>
                  </div>
                  <div class="row" style="margin-top: 20px;">
                    <p style="color:#9e2725"><?php if(isset($msg))
                      {
                        
                      echo $msg;
                      }
                      ?></p>
                    <div class="col text-center">
                      <button type="submit" class="btn btn-primary" value="Send">Request</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-7">
            <div class="card" style="background-color:#EEEDDE;">
              <div class="card-header" >
                <p class="fw-bold" style="font-size:large">Leaves</p>
              </div>
              <div class="card-body" style="padding-left:5%;padding-right:5%">
              <div class="row" >
                        <p style="color: #858585; margin-bottom: 10px;">No Pay</p>
                        <div class="progress" style="padding:0 ;">
                          <div class="progress-bar progress-bar-warning" role="progressbar"
                            aria-valuenow='<?php echo $leaves[' no_pay']-$nopayc['count'] ?>' aria-valuemin="0"
                            aria-valuemax="100" style="padding:0 ;width:
                            <?php echo ($leaves['no_pay']-$nopayc['count'])/$leaves['no_pay']*100 ?>%">
                            <?php echo $leaves['no_pay']-$nopayc['count'] ?> remaining
                          </div>
                        </div>
                      </div>
                      <div class="row " style="margin-top:10px">
                        <p style="color: #858585; margin-bottom: 10px;">Annual</p>
                        <div class="progress"style="padding:0 ;">
                          <div class="progress-bar progress-bar-warning" role="progressbar"
                            aria-valuenow='<?php echo $leaves[' annual']-$annualc['count'] ?>' aria-valuemin="0"
                            aria-valuemax="100" style="width:
                            <?php echo ($leaves['annual']-$annualc['count'])/$leaves['annual']*100 ?>%">
                            <?php echo $leaves['annual']-$annualc['count'] ?> remaining
                          </div>
                        </div>
                      </div>
                      <div class="row " style="margin-top:10px">
                        <p style="color: #858585; margin-bottom: 10px;">Casual</p>
                        <div class="progress"style="padding:0 ;">
                          <div class="progress-bar progress-bar-warning" role="progressbar"
                            aria-valuenow='<?php echo $leaves[' casual']-$casualc['count'] ?>' aria-valuemin="0"
                            aria-valuemax="100" style="width:
                            <?php echo ($leaves['casual']-$casualc['count'])/$leaves['casual']*100 ?>%">
                            <?php echo $leaves['casual']-$casualc['count'] ?> remaining
                          </div>
                        </div>
                      </div>
                      <div class="row " style="margin-top:10px">
                        <p style="color: #858585; margin-bottom: 10px;">Maturnity</p>
                        <div class="progress"style="padding:0 ;">
                          <div class="progress-bar progress-bar-warning" role="progressbar"
                            aria-valuenow='<?php echo $leaves[' maternity']-$maternityc['count'] ?>' aria-valuemin="0"
                            aria-valuemax="100" style="width:
                            <?php echo ($leaves['maternity']-$maternityc['count'])/$leaves['maternity']*100 ?>%">
                            <?php echo $leaves['maternity']-$maternityc['count'] ?> remaining
                          </div>
                        </div>
                      </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  </div>
</body>

=======

<?php 

if(!isset($_COOKIE["uname"]))// $_COOKIE is a variable and login is a cookie name 

	header("location:login.php"); 

?>
<?php 
if(isset($_REQUEST["date"]))
	$msg="Enter the date";
?>
<?php 
if(isset($_REQUEST["err"]))
	$msg="Leave already requested";
if(isset($_REQUEST["errs"]))
  $msg="Error occured";
?>
<?php
    $username=$_COOKIE['uname'];
    $userpassword=$_COOKIE['pass'];

include('user_config.php');
include('db_connector.php');
function get_remaining($id,$type){
  include('user_config.php');
  include('db_connector.php');
  $conn = mysqli_connect($sname, $uname, $password, $db_name);
  $available=mysqli_fetch_row(mysqli_query($conn, "SELECT jupiter.total_count('$id', '$type')"))[0];
  $taken=mysqli_fetch_row(mysqli_query($conn, "SELECT jupiter.approved_count('$id', '$type')"))[0];
  return $available-$taken;
}

try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
} catch (Exception $e) {
    echo "<p style='color:red;'>Database Connection Failed !</p>";
    exit();
}

try {
    $sql2 = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$username' ");
    $row2 = mysqli_fetch_array($sql2);
    $sql1 = mysqli_query($conn, "SELECT * FROM employee WHERE id in (SELECT id FROM user WHERE user_name = '$username' )");
    $row = mysqli_fetch_array($sql1);
    $id=$row2['id'];
    $get = "select id FROM leave_requests WHERE id in (SELECT id FROM supervisor where supervisor_id = '$id') and status='pending'";
    $leave = mysqli_query($conn, $get);
    
    $sql3 = mysqli_query($conn,"SELECT * FROM employment WHERE id='$id'");
    $row4 = mysqli_fetch_array($sql3);

    $jobid=$row4['job_id'];
    $jobq=mysqli_query($conn,"SELECT * FROM job WHERE job_id='$jobid'");
    $job=mysqli_fetch_array($jobq);

    $annualc=mysqli_fetch_row(mysqli_query($conn, "SELECT jupiter.approved_count('$id', '01')"))[0];
    
    $casualc = mysqli_fetch_row(mysqli_query($conn, "SELECT jupiter.approved_count('$id', '02')"))[0];

    $maternityc=mysqli_fetch_row(mysqli_query($conn, "SELECT jupiter.approved_count('$id', '03')"))[0];

    $nopayc=mysqli_fetch_row(mysqli_query($conn, "SELECT jupiter.approved_count('$id', '04')"))[0];

    
    $annuala=mysqli_fetch_row(mysqli_query($conn, "SELECT jupiter.total_count('$id', '01')"))[0];
    
    $casuala=mysqli_fetch_row(mysqli_query($conn, "SELECT jupiter.total_count('$id', '02')"))[0];

    $maternitya=mysqli_fetch_row(mysqli_query($conn, "SELECT jupiter.total_count('$id', '03')"))[0];

    $nopaya=mysqli_fetch_row(mysqli_query($conn, "SELECT jupiter.total_count('$id', '04')"))[0];

    $sql9 = mysqli_query($conn,"SELECT * FROM leave_detail WHERE pay_grade='$row4[pay_grade]'");
    $leaves=mysqli_fetch_array($sql9);

} catch (Exception $e) {
    echo $e;
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <title> Jupiter - Leaveform</title>
  <link rel="icon" type="image/x-icon" href="./img/favicon.png" />
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script>
  function showAlert() {
    alert ($casualc);
  }
  </script>
</head>
<style>
  body {
    background-color: #635666;
  }

  /* The side navigation menu */
  .sidebar {
    margin: 0;
    padding: 0;
    width: 100px;
    background-color: #ECE5C7;
    position: fixed;
    height: 100%;
    overflow: auto;
    text-align: center;
    justify-content: center;
  }

  /* Sidebar links */
  .sidebar a {
    display: flex;
    color: black;
    padding: 10px 12px;
    text-decoration: none;

    height: 82px;
    text-align: center;
    justify-content: center;
  }

  /* Active/current link */
  .sidebar a.active {
    background-color: #354259;
    color: rgb(255, 255, 255);
  }

  /* Links on mouse-over */
  .sidebar a:hover:not(.active) {
    background-color: #555;
    color: white;
  }

  /* Page content. The value of the margin-left property should match the value of the sidebar's width property */
  div.content {
    margin-left: 90px;
    padding: 1px 16px;
    height: auto;
  }

  .container-fluid {
    margin-right: 100px;
    max-width: 1900px;
  }

  /* On screens that are less than 700px wide, make the sidebar into a topbar */
  @media screen and (max-width: 700px) {
    .sidebar {
      width: 100%;
      height: auto;
      position: relative;
    }

    .sidebar a {
      float: right;
    }

    div.content {
      margin-left: 0;
    }
  }

  /* On screens that are less than 400px, display the bar vertically, instead of horizontally */
  @media screen and (max-width: 400px) {
    .sidebar a {
      text-align: end;
      float: none;
    }
  }

  /* Dropdown Button */
  .dropbtn {
    background-color: #3e8e4100;
    color: black;
    padding: 0px;
    width: fit-content;
    max-height: 30px;
    font-size: 16px;
    align-self: flex-end;
    border: none;
  }

  /* The container <div> - needed to position the dropdown content */
  .dropdown {
    position: relative;
    display: inline-block;
  }

  /* Dropdown Content (Hidden by Default) */
  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f186;
    min-width: 145px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0);
    z-index: 1;
    left: 0;
  }

  /* Links inside the dropdown */
  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  /* Change color of dropdown links on hover */
  .dropdown-content a:hover {
    background-color: rgb(221, 221, 221);
  }

  /* Show the dropdown menu on hover */
  .dropdown:hover .dropdown-content {
    display: block;
  }

  /* Change the background color of the dropdown button when the dropdown content is shown */
  .dropdown:hover .dropbtn {
    background-color: #3e8e4100;
  }

  .progress-bar-warning {
    background-color: #635666;

  }

  .btn-sq {
    border-radius: 0px;
    background-color: #CDC2AE;
    height: 82px !important;
    width: 100px !important;
  }

  .btn:hover {
    background-color: #354259;
    border-radius: 0px;
    color: white
  }

  .btn-primary {
    background-color: #635666;
    color: white;
    border-color: #635666;
  }
  .btn-primary:hover {
    background-color: #8d7992;
    border-radius:10%;
    border-color: #8d7992;
    color: white
  }
  /* Fixed sidenav, full height */

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 16px;
  color: #000000;
  display: block;
  border: none;
  background: none;
  width:100%;
  height:10%;
  text-align: center;
  cursor: pointer;
  outline: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  background-color: #555;
  color: white;
}

/* Main content */


/* Add an active class to the active dropdown button */
.active {
  background-color: #354259;
  color: rgb(255, 255, 255);
}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display:none;
  background-color: #fff4c1;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: center;
  padding-right: 8px;
}
</style>

<body>
  <div class="sidebar">
    <a href="./homepage.php" class="text-center"><p class="text-center"><i class="fa fa-home fa-2x" aria-hidden="true"></i><br>Home</p></a>
    <?php if ($row2['user_type'] === 'admin') { ?>
      <a href="./review_employee.php"><p style="font-size:small"><i class="fa fa-users fa-2x" aria-hidden="true"></i><br>Review Employees</p></a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Review Employees</a>
  <?php } ?>
  <?php if ($row2['user_type'] === 'admin' || $jobid === '004') { ?>
      <a href="./pim.php"><p style="font-size:small"><i class="fa fa-cog fa-3x" aria-hidden="true"></i><br>PIM</p></a>
    <?php } else { ?>
      <a href="#" style="display: none;" >PIM</a>
  <?php } ?>
  <?php if ($jobid === '004' || $row2['user_type']=='admin') { ?>
    <a href="./add_new_employee.php"><p style="font-size:small"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i><br>Add New Employee</p></a>    <?php } else { ?>
      <a href="#" style="display: none;" >Add New Employee</a>
  <?php } ?>

    <a class="active" href="./leaveform.php" ><p style="font-size:small"><i class="fa fa-calendar fa-2x mt-2" aria-hidden="true"></i><br>Take a leave</p></a>


  <?php if ($jobid === '004') { ?>
    <button class="dropdown-btn"><p style="font-size:small"><i class="fa fa-line-chart fa-2x mt-2" aria-hidden="true"></i><br>Reports
      <i class="fa fa-caret-down"></i></p>
    </button>
    <div class="dropdown-container">
      <a href="reports.php" style="height:auto;">Employees</a>
      <a href="leave_report.php" style="height:auto;">Leaves</a>
    </div>
    <?php } else { ?>
      <a href="#" style="display: none;" >Reports</a>
  <?php } ?>
  
    <a href="./approve.php"><p style="font-size:small"><i class="fa fa-clock-o fa-2x mt-1" aria-hidden="true"></i><br>Pending Approvals</p></a>
    <?php 
    $nums=mysqli_num_rows($leave);
    if(mysqli_num_rows($leave)>0){
      echo  "<span class='position-relative top-10 start-40 translate-middle badge rounded-pill bg-danger' style='left:13px'>" .$nums;
      }
    ?>
  </div>
  <div class="content">
    <div class="row col-lg-15 " style="background-color:#354259">
      <div class="col">
        <a href='./homepage.php'>
          <img  class="border-dark " src="./img/jupiter_logo.png"
            style="width:250px;margin-bottom: 5px;margin-left: 10px;">
          </a>
      </div>
      <div class="col-lg-6 align-self-center text-center">
        <h4 style="color:rgb(255, 255, 255)">Jupiter Employee Portal</h4>
      </div>
      <div class="col-sm-3 align-self-lg-center d-flex justify-content-end">
        <div class="row mx-0 text-end">
          <div class="col-auto text-end">
            <?php
                          $sql3 = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");
                          $row3 = mysqli_fetch_array($sql3);
                          $name = $row2['img_name'];
                          $stmt = $pdo->prepare("SELECT `img_data` FROM `user` WHERE `img_name`=?");
                          $stmt->execute([$name]);
                          $img = $stmt->fetch();
                          $img = $img["img_data"];
                          $img = base64_encode($img);
                          $ext = pathinfo($name, PATHINFO_EXTENSION);
                          if (!empty($img)){
                            echo "<img src='data:image/" . $ext . ";base64," . $img . "' height='auto' width='30px' class='rounded-circle' alt='...'/>";
                          }
                          else{
                            echo "<img src='./img/user-default.png' height='auto' width='30px' class='rounded-circle' alt='...'/>";
                          }                          ?>

          </div>
          <div class="col-lg-auto text-end align-content-end" style="margin-left:-4%;">
            <div class="dropdown align-self-end" style="float:right">
              <button class="dropbtn align-self-end">
                <p style="color:white">
                  <?php echo $row['first_name'].' '.$row['last_name'] ?> &nbsp<i class="fa fa-caret-down"></i>
                </p>
              </button>
              <div class="dropdown-content" style="left:0px">
                <a href="./account_details.php">Account details</a>
                <a href="./logout.php">Logout</a>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    <div class="container-fluid mx-0">
      <div class="card" style="background-color: #eeedde78;padding: 2%;min-height: 85vh;margin-top: 1%;">
        <div class="row justify-content-center">
          <div class="col-auto">
            <div class="card" style="background-color: #EEEDDE;min-height:80vh;">
              <div class="card-header" style="background-color:#ECE5C7 ">
              <h4 style="text-align: center; " class="md-5 mt-2">Leave Details</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="leave_request.php">
                  <div class="md-3">
                    <div class="row align-self-center">
                      <div class="col">
                        <p style="margin: 0" style="font-size: 3px">Name</p>
                        <input type="text" style="margin-top: 1px" class="form-control" name="xuname"
                          value="<?php echo $row['first_name'].' '.$row['last_name'] ?>" placeholder="<?php $row['id'] ?>" readonly />
                      </div>
                      <div class="col">
                        <p style="margin: 0" style="font-size: 3px">ID</p>
                        <input type="text" style="margin-top: 1px" class="form-control" name="xid"
                          value="<?php echo $row['id'] ?>" placeholder="<?php echo $row['id'] ?>" readonly />
                      </div>
                    </div>
                    <p style="margin: 0" style="font-size: 3px">Date</p>
                    <input type="date" style="margin-top: 1px" class="form-control" name="xdate" min ="<?php echo date("Y-m-d")?>" required/>
                  </div>
                  <div>
                    <p style="margin: 0" style="font-size: 3px">
                      Select Leave Type
                    </p>
                    <select class="form-select" name="xleave_type" required>
                      <option value="">Leave Type</option>
                      <?php
                        $query = "select * from leave_type";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($result)) {
                          if (get_remaining($id, $row['type_id'])>0){
                            echo "<option value='" . $row['type_id'] . "'>" . $row['name'] . "</option>";
                          }
                        }
                        ?>
                    </select>
                  </div>
                  <div class="row" style="margin-top: 20px;">
                    <p style="color:#9e2725"><?php if(isset($msg))
                      {
                        
                      echo $msg;
                      }
                      ?></p>
                    <div class="col text-center">
                      <button type="submit" class="btn btn-primary" value="Send">Request</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-7">
            <div class="card" style="background-color:#EEEDDE;">
              <div class="card-header" style="background-color:#ECE5C7 ">
              <h4 style="text-align: center; " class="md-5 mt-2">Leaves Remaining</h4>
              </div>
              <div class="card-body" style="padding-left:5%;padding-right:5%">
                <div class="row" >
                  <p style="color: #858585; margin-bottom: 10px;">No Pay</p>
                  <div class="progress" style="padding:0 ;">
                    <div class="progress-bar progress-bar-warning" role="progressbar"
                      aria-valuenow='<?php echo $nopaya-$nopayc ?>' aria-valuemin="0"
                      aria-valuemax="100" style="padding:0 ;width:
                      <?php echo ($nopaya-$nopayc)/$nopaya*100 ?>%">
                      <?php echo $nopaya-$nopayc ?> remaining
                    </div>
                  </div>
                </div>
                <div class="row " style="margin-top:10px">
                  <p style="color: #858585; margin-bottom: 10px;">Annual</p>
                  <div class="progress"style="padding:0 ;">
                    <div class="progress-bar progress-bar-warning" role="progressbar"
                      aria-valuenow='<?php echo $nopaya-$annualc ?>' aria-valuemin="0"
                      aria-valuemax="100" style="width:
                      <?php echo ($annuala-$annualc)/$annuala*100 ?>%">
                      <?php echo $annuala-$annualc ?> remaining
                    </div>
                  </div>
                </div>
                <div class="row " style="margin-top:10px">
                  <p style="color: #858585; margin-bottom: 10px;">Casual</p>
                  <div class="progress"style="padding:0 ;">
                    <div class="progress-bar progress-bar-warning" role="progressbar"
                      aria-valuenow='<?php echo $casuala-$casualc ?>' aria-valuemin="0"
                      aria-valuemax="100" style="width:
                      <?php echo ($casuala-$casualc)/$casuala*100 ?>%">
                      <?php echo $casuala-$casualc ?> remaining
                    </div>
                  </div>
                </div>
                <div class="row " style="margin-top:10px">
                  <p style="color: #858585; margin-bottom: 10px;">Maturnity</p>
                  <div class="progress"style="padding:0 ;">
                    <div class="progress-bar progress-bar-warning" role="progressbar"
                      aria-valuenow='<?php echo $maternitya-$maternityc ?>' aria-valuemin="0"
                      aria-valuemax="100" style="width:
                      <?php echo ($maternitya-$maternityc)/$maternitya*100 ?>%">
                      <?php echo $maternitya-$maternityc ?> remaining
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  </div>
</body>
<script>
  var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>
>>>>>>> Stashed changes:jupiter/leaveform.php
</html>