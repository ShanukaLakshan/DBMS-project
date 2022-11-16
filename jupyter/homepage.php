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
if(isset($_REQUEST['c'])){
  echo "<script>alert('Changed Successfully');</script>";
}

try {
    $sql2 = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$username'");
    $row2 = mysqli_fetch_array($sql2);

    $sql1 = mysqli_query($conn, "SELECT * FROM employee WHERE id in (SELECT id FROM user WHERE user_name = '$username')");
    $row = mysqli_fetch_array($sql1);
    $id=$row['id'];


    $get_leaves = "select id FROM leave_requests WHERE id in (SELECT id FROM supervisor where supervisor_id = '$id') and status='pending'";
    $leave = mysqli_query($conn, $get_leaves);

    $sql3 = mysqli_query($conn,"SELECT * FROM employment WHERE id='$id'");
    $row4 = mysqli_fetch_array($sql3);
    
    $jobid=$row4['job_id'];
    $jobq=mysqli_query($conn,"SELECT * FROM job WHERE job_id='$jobid'");
    $job=mysqli_fetch_array($jobq);

    $statusq=mysqli_query($conn,"SELECT * FROM emp_status WHERE stat_id='$row4[stat_id]'");
    $status=mysqli_fetch_array($statusq);

    $sql4 = mysqli_query($conn,"SELECT * FROM address WHERE id='$id'");
    $row5 = mysqli_fetch_array($sql4);

    $sql5 = mysqli_query($conn,"SELECT count(id) as count FROM leave_requests WHERE id='$id' and status='approved' and type_id='02'");
    $casualc=mysqli_fetch_array($sql5);

    $sql6 = mysqli_query($conn,"SELECT count(id) as count FROM leave_requests WHERE id='$id' and status='approved' and type_id='01'");
    $annualc=mysqli_fetch_array($sql6);

    $sql7 = mysqli_query($conn,"SELECT count(id) as count FROM leave_requests WHERE id='$id' and status='approved' and type_id='03'");
    $maternityc=mysqli_fetch_array($sql7);

    $sql8 = mysqli_query($conn,"SELECT count(id) as count FROM leave_requests WHERE id='$id' and status='approved' and type_id='04'");
    $nopayc=mysqli_fetch_array($sql8);

    $casualaq = mysqli_query($conn,"SELECT * FROM leave_detail WHERE type_id='02' AND pay_grade='$row4[pay_grade]'");
    $casuala=mysqli_fetch_array($casualaq);

    $annualaq = mysqli_query($conn,"SELECT * FROM leave_detail WHERE type_id='01' AND pay_grade='$row4[pay_grade]'");
    $annuala=mysqli_fetch_array($annualaq);

    $maternityaq = mysqli_query($conn,"SELECT * FROM leave_detail WHERE type_id='03' AND pay_grade='$row4[pay_grade]'");
    $maternitya=mysqli_fetch_array($maternityaq);

    $nopayaq = mysqli_query($conn,"SELECT * FROM leave_detail WHERE type_id='04' AND pay_grade='$row4[pay_grade]'");
    $nopaya=mysqli_fetch_array($nopayaq);

    $dept_id=$row4['dept_id'];
    $sql10=mysqli_query($conn,"SELECT * FROM department WHERE id='$dept_id'");
    $dept=mysqli_fetch_array($sql10);
} catch (Exception $e) {
    echo $e;
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <title>Jupiter - Portal</title>
  <link rel="icon" type="image/x-icon" href="./img/favicon.png" />
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
    border-color: #354259;
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
  .btn-sq{
    border-radius: 0px;
    background-color:#CDC2AE;
    height: 82px !important;
    width: 100px !important;
  }
  .btn:hover{
    background-color: #354259;
    border-radius:0px;
    color:white
  }
</style>

<body>

  <div class="sidebar">
    <a class="active" href="./homepage.php">Home</a>
    <?php if ($row2['user_type'] === 'admin') { ?>
      <a href="./review_employee.php">Review Employees</a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Review Employees</a>
  <?php } ?>
  <?php if ($jobid === '004') { ?>
      <a href="./add_new_employee.php">Add New Employee</a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Add New Employee</a>
  <?php } ?>

    <a href="./leaveform.php" >Request a Leave</a>


  <?php if ($jobid === '004') { ?>
    <a href="./reports.php" >Reports</a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Reports</a>
  <?php } ?>
    
    <a href="./approve_leaves.php" style="position-relative">Pending Approvals</a>
    <?php 
    $nums=mysqli_num_rows($leave);
    if(mysqli_num_rows($leave)>0){
        echo  "<span class='position-absolute top-70 start-90 translate-middle badge rounded-pill bg-danger'>" .$nums;
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
                }
                ?>

          </div>
          <div class="col-lg-auto text-end align-content-end" style="margin-left:-4%;">
            <div class="dropdown align-self-end" style="float:right">
              <button class="dropbtn align-self-end"> <p style="color:white">
                <?php echo $row['name'] ?> &nbsp<i class="fa fa-caret-down"></i></p>
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
      <div class="row" style="margin-top:1%">
        <div class="col">
          <div class="card rounded-3" style="padding: 2%;background-color: rgba(255, 255, 255, 0.5);">
            <div class="row">
              <div class="col justify-content-md-start">
                <div class="card" style="padding:2%;background-color:#EEEDDE">
                  <div class="text-center">
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
                                          echo "<img src='data:image/" . $ext . ";base64," . $img . "' height='auto' width='300px' class='rounded-circle' alt='...'/>";
                                        }
                                        else{
                                          echo "<img src='./img/user-default.png' height='auto' width='300px' class='rounded-circle' alt='...'/>";
                                        }                                        ?>

                    <h5 class="card-title fw-bold" style="margin-top: 10px;">
                      <?php echo $row['name'] ?>
                    </h5>
                    <h6 class="card-title" style="margin-top: -5px;">
                      <?php echo $username ?>
                    </h6>
                  </div>
                  <div class="container-fluid">
                    <div class="row justify-content-md-center w-75 offset-md-1" style="margin-top:10px;">
                      <div class="col col-md-auto">
                        <p style="color: #858585; margin-bottom: 2px;">Gender</p>
                        <p>
                          <?php echo $row['gender'] ?>
                        </p>
                      </div>
                      <div class="col col-md-auto">
                        <p style="color: #858585; margin-bottom: 2px;">Martial Status</p>
                        <p>
                          <?php echo $row['marital_status'] ?>
                        </p>
                      </div>
                      <div class="col col-md-auto">
                        <p style="color: #858585; margin-bottom: 2px;">ID</p>
                        <p>
                          <?php echo $row['id'] ?>
                        </p>
                      </div>
                    </div>
                    <div class="row justify-content-md-center w-75 offset-md-1">
                      <div class="col col-md-auto ">
                        <p style="color: #858585; margin-bottom: 2px;">Address</p>
                        <p>
                          <?php echo $row5['address_line_1'].','.$row5['address_line_2'].','.$row5['city'].','.$row5['postal_code']  ?>
                        </p>
                      </div>
                      <div class="col col-md-auto">
                        <p style="color: #858585; margin-bottom: 2px;">Phone</p>
                        <p>
                          <?php echo $row['phone_number'] ?>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col justify-content-center">
                <div class="row align-self-center">
                  <div class="card" style="background-color:#EEEDDE">
                    <div class="card-header">
                      <p class="fw-bold" style="font-size:large">Employment</p>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col col-sm-4">
                          <p style="color: #858585; margin-bottom: 2px;">Department</p>
                          <p>
                            <?php echo $dept['name'] ?>
                          </p>
                        </div>
                        <div class="col col-sm-4">
                          <p style="color: #858585; margin-bottom: 2px;">Designation</p>
                          <p>
                            <?php echo $job['job_title'] ?>
                          </p>
                        </div>
                        <div class="col col-sm-4">
                          <p style="color: #858585; margin-bottom: 2px;">Status</p>
                          <p>
                            <?php echo $status['title'] ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row align-self-center  " style="margin-top:10px">
                  <div class="card" style="background-color:#EEEDDE;margin-top: 4%;">
                    <div class="card-header" >
                      <p class="fw-bold" style="font-size:large">Leaves</p>
                    </div>
                    <div class="card-body" style="padding-left:5%;padding-right:5%">
                      <div class="row" >
                        <p style="color: #858585; margin-bottom: 10px;">No Pay</p>
                        <div class="progress" style="padding:0 ;">
                          <div class="progress-bar progress-bar-warning" role="progressbar"
                            aria-valuenow='<?php echo $nopaya['leaves']-$nopayc['count'] ?>' aria-valuemin="0"
                            aria-valuemax="100" style="padding:0 ;width:
                            <?php echo ($nopaya['leaves']-$nopayc['count'])/$nopaya['leaves']*100 ?>%">
                            <?php echo $nopaya['leaves']-$nopayc['count'] ?> remaining
                          </div>
                        </div>
                      </div>
                      <div class="row " style="margin-top:10px">
                        <p style="color: #858585; margin-bottom: 10px;">Annual</p>
                        <div class="progress"style="padding:0 ;">
                          <div class="progress-bar progress-bar-warning" role="progressbar"
                            aria-valuenow='<?php echo $nopaya['leaves']-$annualc['count'] ?>' aria-valuemin="0"
                            aria-valuemax="100" style="width:
                            <?php echo ($annuala['leaves']-$annualc['count'])/$annuala['leaves']*100 ?>%">
                            <?php echo $annuala['leaves']-$annualc['count'] ?> remaining
                          </div>
                        </div>
                      </div>
                      <div class="row " style="margin-top:10px">
                        <p style="color: #858585; margin-bottom: 10px;">Casual</p>
                        <div class="progress"style="padding:0 ;">
                          <div class="progress-bar progress-bar-warning" role="progressbar"
                            aria-valuenow='<?php echo $casuala['leaves']-$casualc['count'] ?>' aria-valuemin="0"
                            aria-valuemax="100" style="width:
                            <?php echo ($casuala['leaves']-$casualc['count'])/$casuala['leaves']*100 ?>%">
                            <?php echo $casuala['leaves']-$casualc['count'] ?> remaining
                          </div>
                        </div>
                      </div>
                      <div class="row " style="margin-top:10px">
                        <p style="color: #858585; margin-bottom: 10px;">Maturnity</p>
                        <div class="progress"style="padding:0 ;">
                          <div class="progress-bar progress-bar-warning" role="progressbar"
                            aria-valuenow='<?php echo $maternitya['leaves']-$maternityc['count'] ?>' aria-valuemin="0"
                            aria-valuemax="100" style="width:
                            <?php echo ($maternitya['leaves']-$maternityc['count'])/$maternitya['leaves']*100 ?>%">
                            <?php echo $maternitya['leaves']-$maternityc['count'] ?> remaining
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
      </div>
    </div>


</body>

</html>