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


try {
    $sql2 = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$username'");
    $row2 = mysqli_fetch_array($sql2);
    $sql1 = mysqli_query($conn, "SELECT * FROM employee WHERE id in (SELECT id FROM user WHERE user_name = '$username')");
    $emprow = mysqli_fetch_array($sql1);
    $id=$emprow['id'];
    $sql3 = mysqli_query($conn,"SELECT * FROM employment WHERE id='$id'");
    $row4 = mysqli_fetch_array($sql3);
    $jobid=$row4['job_id'];
    $get_leaves = "select id FROM leave_requests WHERE id in (SELECT id FROM supervisor where supervisor_id = '$id') and status='pending'";
    $leave = mysqli_query($conn, $get_leaves);
} catch (Exception $e) {
    echo $e;
    exit();
}
$type = '';
if(!empty($_POST['type'])){
  $type = $_POST['type'];
}
$jj='001';
if(!empty($_POST['job_id']) && !empty($_POST['pay_grade']) && !empty($_POST['amount'])){
    $update=$conn->prepare("UPDATE salary SET  amount=?  WHERE job_id=? AND pay_grade=?");
    // UPDATE salary SET amount=100000  WHERE job_id=001 AND pay_grade=1;
    $update->bind_param("sss",$_POST['amount'],$_POST['job_id'],$_POST['pay_grade']);
    try{
        $conn->begin_transaction();
        $update->execute();
        $message = "Record Modified Successfully";
    echo $message;
    }
    catch(Exception $e){
        $conn->rollback();
        echo "Error: " . $e->getMessage();
        $message = "Error in Modification. Try Again!";
    }
    $conn->commit();
    echo $message;
}
if(!empty($_POST['title']) && !empty($_POST['pay1']) && !empty($_POST['pay2']) && !empty($_POST['pay3'])){
    $jobidq = mysqli_fetch_array(mysqli_query($conn, "SELECT job_id FROM job ORDER BY job_id DESC LIMIT 1"));
    $jobid = $jobidq['job_id'] + 1;
    $jobid = '00'.$jobid;
    $update1=$conn->prepare("INSERT INTO job VALUES(?, ?)");
    $update1->bind_param("ss",$_POST['title'],$jobid);
    $grade = '1';
    $update2=$conn->prepare("INSERT INTO salary VALUES(?, ?, ?)");
    $update2->bind_param("sss",$jobid,$grade,$_POST['pay1']);
    $grade1 = '2';
    $update3=$conn->prepare("INSERT INTO salary VALUES(?, ?, ?)");
    $update3->bind_param("sss",$jobid,$grade1,$_POST['pay2']);
    $grade2 = '3';
    $update4=$conn->prepare("INSERT INTO salary VALUES(?, ?, ?)");
    $update4->bind_param("sss",$jobid,$grade2,$_POST['pay3']);
    try{
        $conn->begin_transaction();
        $update1->execute();
        $update2->execute();
        $update3->execute();
        $update4->execute();
        $message = "Record Modified Successfully";
    }
    catch(Exception $e){
        $conn->rollback();
        echo "Error: " . $e->getMessage();
        $message = "Error in Modification. Try Again!";
    }
    $conn->commit();
}
?>

<!DOCTYPE html>
<html lang="en">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
      $( function() {
        $( "#dialog" ).dialog();
      } );
  </script>
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
  <?php
if(isset($_REQUEST['c'])){
  echo "<script>alert('Changed Successfully');</script>";
}
?>

  <div class="sidebar">
  <a href="./homepage.php" class="text-center"><p class="text-center"><i class="fa fa-home fa-2x" aria-hidden="true"></i><br>Home</p></a>
    <?php if ($row2['user_type'] === 'admin') { ?>
      <a href="./review_employee.php"><p style="font-size:small"><i class="fa fa-users fa-2x" aria-hidden="true"></i><br>Review Employees</p></a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Review Employees</a>
  <?php } ?>
  <?php if ($row2['user_type'] === 'admin' || $jobid === '004') { ?>
      <a class="active" href="./pim.php"><p style="font-size:small"><i class="fa fa-cog fa-3x" aria-hidden="true"></i><br>PIM</p></a>
    <?php } else { ?>
      <a href="#" style="display: none;" >PIM</a>
  <?php } ?>
  <?php if ($jobid === '004') { ?>
      <a href="./add_new_employee.php"><p style="font-size:small"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i><br>Add New Employee</p></a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Add New Employee</a>
  <?php } ?>

    <a  href="./leaveform.php" ><p style="font-size:small"><i class="fa fa-calendar fa-2x mt-2" aria-hidden="true"></i><br>Take a leave</p></a>


  <?php if ($jobid === '004') { ?>
    <button class="dropdown-btn"><p style="font-size:small"><i class="fa fa-line-chart fa-2x mt-2" aria-hidden="true"></i><br>Reports
      <i class="fa fa-caret-down"></i></p>
    </button>
    <div class="dropdown-container">
      <a href="reports.php" style="height:auto;">Employees</a>
      <a  href="leave_report.php" style="height:auto;">Leaves</a>
    </div>
    <?php } else { ?>
      <a href="#" style="display: none;" >Reports</a>
  <?php } ?>
  
    <a href="./approve_leaves.php"><p style="font-size:small"><i class="fa fa-clock-o fa-2x mt-1" aria-hidden="true"></i><br>Review Employees</p></a>
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
                }
                ?>

          </div>
          <div class="col-lg-auto text-end align-content-end" style="margin-left:-4%;">
            <div class="dropdown align-self-end" style="float:right">
              <button class="dropbtn align-self-end"> <p style="color:white">
                <?php echo $emprow['first_name'].' '.$emprow['last_name'] ?> &nbsp<i class="fa fa-caret-down"></i></p>
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
    <div class="card" style="background-color: rgba(255, 255, 255, 0.423);">
        <div class="card-body">
            <div class="row align-content-center justify-content-center">
        <div class="col">
            <div class="card shadow-lg">
              <div class="card-header"style="background-color: #ECE5C7;">
              <div class="row align-content-center">
                <div class="col align-content-center my-auto">
                  <h3 class="text-start">Employees Details</h3><br>
                </div>
                <div class="col-auto ">
                  <div class="row justify-content-end">
                    <div class="col-auto">
                          <form action='' method=POST style="margin-bottom: 30px;">
                            <div class="row justify-content-center mt-3">
                            <div class="col-auto">
                              <select class="form-select" name="type" required>
                                <option value="">Editor Type</option>
                                <option value="salary">Edit Salaries</option>
                                <option value="job">Add New Jobs</option>
                              </select>
                            </div>
                            <div class="col-auto">
                              <input class="btn btn-primary" type="submit" value="Filter" />
                            </div>
                          </div>
                        </form>
                      
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
    <div class="container-fluid mx-0">
            <div class="container-fluid mx-0">
                <div class="card" style="background-color: #eeedde78;padding: 2%;min-height: 85vh;margin-top: 1%;">
                
                     <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card" style="background-color: #EEEDDE;">
                                    <?php
                                    if ($type == 'salary') { ?>
                                <div class="card-header" style="background-color:#ECE5C7 ">
                                    <h5 class="text-center mt-2">Salaries</h5>
                                </div>
                                <div class="card-body row justify-content-center" style="padding:2%">
                                        <div class="p-2">
                                            <?php
                                            $dta = mysqli_query($conn, "SELECT * FROM job INNER JOIN salary USING(job_id)");
                                            if (mysqli_num_rows($dta) > 0) { ?>
                                                <div class="md-3">
                                                        <div class="row">
                                                            <div class="col">
                                                                <p style="margin: 0" style="font-size: 3px;">Job ID</p>
                                                            </div>
                                                           <div class="col">
                                                                <p style="margin: 0" style="font-size: 3px;">Job Title</p>
                                                            </div>
                                                            <div class="col">
                                                                <p style="margin: 0" style="font-size: 3px;">Pay Grade</p>
                                                            </div>
                                                            <div class="col">
                                                                <p style="margin: 0" style="font-size: 3px;">Amount</p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        while ($dtarow = mysqli_fetch_assoc($dta)) { ?>
                                                        <form action='' method='POST'>
                                                        <div class="row" style="margin-top: 5px; margin-bottom: 5px;">
                                                            <div class="col">
                                                                <input type="text" style="margin-top: 1px" class="form-control"
                                                                    name="job_id" value="<?php echo $dtarow["job_id"]; ?>" readonly>

                                                            </div>
                                                            <div class="col">
                                                                <input type="text" style="margin-top: 1px" class="form-control"
                                                                    name="job_title" value="<?php echo $dtarow["job_title"]; ?> " readonly>
                                                            </div>
                                                            <div class="col">
                                                                <input type="text" style="margin-top: 1px" class="form-control"
                                                                    name="pay_grade" value="<?php echo $dtarow["pay_grade"]; ?>" readonly>
                                                            </div>
                                                            <div class="col">
                                                                <input type="number" style="margin-top: 1px" class="form-control"
                                                                    name="amount" value="<?php echo $dtarow["amount"]; ?>">
                                                            </div>
                                                            <div class="col">
                                                            <input class="btn btn-success" type="submit" value="Edit" />
                                                            </div>
                                                        </div>
                                                        </form>
                                                        <?php
                                                        } ?>
                                                </div>
                                            <?php } ?>
                                    <?php } else { ?>
                                        <p style="display: none;"></p>
                                    <?php } ?>
                                    <?php
                                    if ($type == 'job') { ?>
                                <div class="card-header" style="background-color:#ECE5C7 ">
                                    <h5 class="text-center mt-2">Add New Job</h5>
                                </div>
                                <form action='' method='POST'>
                                <div style="padding: 10px">
                                <div class="md-3">
                                        <div class="col-4">
                                        <p style="margin: 0" style="font-size: 3px;">Job Title</p>
                                        <input type="text" style="margin-top: 1px" class="form-control" name="title" required>
                                       </div>
                                        <div class="row">
                                            <div class="col">
                                                <p style="margin: 0" style="font-size: 3px;">Pay Grade 1 Salary</p>
                                                <input type="number" style="margin-top: 1px" class="form-control"
                                                    name="pay1" required>
                                            </div>
                                            <div class="col">
                                                <p style="margin: 0" style="font-size: 3px;">Pay Grade 2 Salary</p>
                                                <input type="number" style="margin-top: 1px" class="form-control"
                                                    name="pay2" required>
                                            </div>
                                            <div class="col">
                                                <p style="margin: 0" style="font-size: 3px;">Pay Grade 3 Salary</p>
                                                <input type="number" style="margin-top: 1px" class="form-control"
                                                    name="pay3" required>
                                            </div>
                                        </div>
                                </div>
                                <div class="row justify-content-center" style="margin-top: 10px; margin-bottom: 10px;">
                                        <div class="col-auto">
                                            <button type="submit" name="submit" value="Submit"
                                             class="btn btn-success">Add</button>
                                        </div>
                                </div>
                                </div>
                                </form>
                                    <?php } ?>
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
    dropdown[i].addEventListener("click", function () {
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
</html>