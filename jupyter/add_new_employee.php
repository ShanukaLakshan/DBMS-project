<<<<<<< Updated upstream:jupyter/add_new_employee.php
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
    $sql2 = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$username' AND password = '$userpassword'");
    $row2 = mysqli_fetch_array($sql2);

    $sql1 = mysqli_query($conn, "SELECT * FROM employee WHERE id in (SELECT id FROM user WHERE user_name = '$username' AND password = '$userpassword')");
    $row = mysqli_fetch_array($sql1);
    $id=$row['id'];

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
    $dept_id=$row4['dept_id'];
    $sql10=mysqli_query($conn,"SELECT * FROM department WHERE id='$dept_id'");
    $dept=mysqli_fetch_array($sql10);
} catch (Exception $e) {
    echo "<p style='color:red;'>Username or Password is incorrect !</p>";
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
      <a href="#" style="display: none;" >Review Employees</a>
  <?php } ?>
  <?php if ($row4['job_title'] === 'HR Manager') { ?>
      <a class="active" href="../jupyter/add_new_employee.php">Add New Employee</a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Add New Employee</a>
  <?php } ?>
    <a href="../jupyter/leaveform.php" >Request a Leave</a>
    <a href="../jupyter/approve_leaves.php" style="position:relative">Pending Approvals</a>
    <span class="position-absolute top-70 start-90 translate-middle badge rounded-pill bg-danger"> <?php echo "" . mysqli_num_rows($leave); ?>

  </div>
  <div class="content">
    <div class="row col-lg-15 " style="background-color:#354259;">
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
                <a href="../jupyter/account_details.php">Account details</a>
                <a href="../jupyter/logout.php">Logout</a>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    <div class="container-fluid mx-1">
        <div class="row h-100 justify-content-center">
            <div class="card h-100" style="background-color: #ffffff74;">
              <div class="row justify-content-center">
                <div class="col-auto">
                    <div class="card  rounded-3  " style="width: 50rem; background-color: #ffffff;padding: 2%;margin:2% ">
              <div class="row">
                <div class="col">
                  <h2 style="text-align: center; " class="md-5">Enter your details</h2>
                </div>
              </div>
              <form action="add_user_database.php" method="POST">
                <div class="row ">
                  <div class="col-md-6">
    
                    <h5 class="md-3">Personal details</h5>
                    <div class="md-3">
                      <div class="row">
                        <div class="col">
                          <input type="text" class="form-control" name="xxfname" placeholder="First name" required />
                        </div>
                        <div class="col">
                          <input type="text" class="form-control" name="xxlname" placeholder="Last name" required />
                        </div>
                      </div>
                      <input type="mail" style="margin-top: 10px" name="xxemail" placeholder="Email : saman@gmail.com" class="form-control" required />
                      <input type="text" style="margin-top: 10px" name="xxphone" placeholder="Phone : 0771234567" maxlength="10" minlength="10" class="form-control" required />
                      <input type="date" style="margin-top: 10px" name="xxbdate" class="form-control" required />
                    </div>
                    <div class="row">
                      <div class="col">
                        <label style="margin-top: 10px" class="col-sm-7 control-label">Select Gender</label>
                        <div class="col-sm-8">
                          <label class="radio-inline">
                            <input type="radio" name="xxgender" value="male" required /> Male
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="xxgender" value="female" required /> Female
                          </label>
                        </div>
                      </div>
                      <div class="col">
                        <select class="form-select" name="xxmarital" style="margin-top:30px" required>
                          <option value="">Marital Status</option>
                          <option value="single">Single</option>
                          <option value="married">Married</option>
                          <option value="divorced">Divorced</option>
                          <option value="widowed">Widowed</option>
                        </select>
                      </div>
                    </div>
                    <label style="margin-top: 10px" class="col-sm-4 control-label">Address</label>
                    <div class="row g-3">
                      <div class="col">
                        <input style="margin-top:10px; margin-bottom:10px" type="text" class="form-control" name="xxadd1" placeholder="Address line 1" required />
                      </div>
                    </div>
                    <div class="row g-3">
                      <div class="col">
                        <input style="margin-bottom:10px" type="text" class="form-control" name="xxadd2" placeholder="Address line 2" required />
                      </div>
                    </div>
                    <div class="row g-3">
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="xxcity" placeholder="City" required />
                      </div>
                      <div class="col-sm-4">
                        <select class="form-select" name="xxprovince" required>
                          <option value="">Province</option>
                          <option value="Central">Central</option>
                          <option value="North Central">North Central</option>
                          <option value="Northern">Northern</option>
                          <option value="Eastern">Eastern</option>
                          <option value="North Western">North Western</option>
                          <option value="Southern">Southern</option>
                          <option value="Uva">Uva</option>
                          <option value="Southern">Southern</option>
                          <option value="Western">Western</option>
                        </select>
                      </div>
                      <div class="col-sm">
                        <input type="text" class="form-control" name="xxzip" placeholder="Zip" required />
                      </div>
                    </div>
    
                    <br />
    
                  </div>
                  <div class="col-md-6">
                    <h5 style="margin-top: 10px" class="md-3">Employment details</h5>
                    <div class="md-3">
                      <div class="row">
                        <div class="col">
                          <div class="col">
                            <select class="form-select" name="xxjtitle" required>
                              <option value="">Job Title</option>
                              <?php
                              $query = "SELECT DISTINCT job_title FROM employment ORDER BY job_title";
                              $result = $conn->query($query);
                              if ($result->num_rows > 0) {
                                $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                              }
                              foreach ($options as $option) {
                              ?>
                                <option value="<?php echo $option['job_title']; ?>"><?php echo $option['job_title']; ?> </option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col">
                          <select class="form-select" name="xxdpt" required>
                            <option value="">Department</option>
                            <?php
                            $query = "SELECT DISTINCT name FROM department ORDER BY name ASC";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                              $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            }
                            foreach ($options as $option) {
                            ?>
                              <?php
                              $query2 = "SELECT DISTINCT id FROM department where name='" . $option['name'] . "'";
                              $dept = mysqli_query($conn, $query2);
                              $dept1 = mysqli_fetch_assoc($dept);
                              $dept_id = $dept1['id'];
                              ?>
                              <option value="<?php echo $dept_id; ?>"><?php echo $option['name']; ?> </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
    
                      <div style="margin-top: 2px" class="row g-3">
                        <div class="col">
                          <select class="form-select" name="xxpaygrade" required>
                            <option value="">Pay Grade</option>
                            <?php
                            $query = "SELECT DISTINCT pay_grade FROM salary ORDER BY pay_grade ASC";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                              $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            }
                            foreach ($options as $option) {
                            ?>
                              <option value="<?php echo $option['pay_grade']; ?>"><?php echo $option['pay_grade']; ?> </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col">
                          <select class="form-select" name="xxstatus" required>
                            <option value="">Status</option>
                            <option value="Freelance">Freelance</option>
                            <option value="Intern-Part time">Intern - Part time</option>
                            <option value="Intern-Full time">Intern - Full time</option>
                            <option value="Contract-Part time">Contract - Part time</option>
                            <option value="Contract-Full time">Contract - Full time</option>
                            <option value="Contract-Part time">Permanent</option>
                          </select>
                        </div>
                      </div>
                      <div class="row g-3" style="margin-top: 0.5px;">
                        <div class="col">
                        <input type="text" class="form-control" name="xxsid" placeholder="Supervisor ID" required />
                        </div>
                      </div>
                    </div>
    
                    <h5 style="margin-top: 10px" class="md-3">Account details</h5>
                    <div class="md-3">
                      <div class="row">
                        <div class="col">
                          <input type="text" class="form-control" name="xxbnkname" placeholder="Bank name" required />
                        </div>
                        <div class="col">
                          <input type="text" class="form-control" name="xxbrnchname" placeholder="Branch name" required />
                        </div>
                      </div>
                      <input type="text" style="margin-top: 10px" name="xxaccn" placeholder="Account Number" class="form-control" required />
                    </div>
    
                  </div>
                </div>
                <div class="row">
                  <div class="col text-center">
                    <input class="btn btn-primary" type="submit" value="Send" />
                  </div>
                </div>
              </form>
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
    $sql2 = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$username' ");
    $row2 = mysqli_fetch_array($sql2);

    $sql1 = mysqli_query($conn, "SELECT * FROM employee WHERE id in (SELECT id FROM user WHERE user_name = '$username' )");
    $row = mysqli_fetch_array($sql1);
    $id=$row['id'];

    $get_leaves = "select id FROM leave_requests WHERE id in (SELECT id FROM supervisor where supervisor_id = '$id') and status='pending'";
    $leave = mysqli_query($conn, $get_leaves);

    $sql3 = mysqli_query($conn,"SELECT * FROM employment WHERE id='$id'");
    $row4 = mysqli_fetch_array($sql3);
    $jobid=$row4['job_id'];
    $jobq=mysqli_query($conn,"SELECT * FROM job WHERE job_id='$jobid'");
    $job=mysqli_fetch_array($jobq);


    $sql9 = mysqli_query($conn,"SELECT * FROM leave_detail WHERE pay_grade='$row4[pay_grade]'");
    $leaves=mysqli_fetch_array($sql9);
    $dept_id=$row4['dept_id'];
    $sql10=mysqli_query($conn,"SELECT * FROM department WHERE id='$dept_id'");
    $dept=mysqli_fetch_array($sql10);
} catch (Exception $e) {
    echo "<p style='color:red;'>Username or Password is incorrect !</p>";
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
    <a class="active" href="./add_new_employee.php"><p style="font-size:small"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i><br>Add New Employee</p></a>    <?php } else { ?>
      <a href="#" style="display: none;" >Add New Employee</a>
  <?php } ?>

    <a  href="./leaveform.php" ><p style="font-size:small"><i class="fa fa-calendar fa-2x mt-2" aria-hidden="true"></i><br>Take a leave</p></a>


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
  
    <a href="./approve_leaves.php"><p style="font-size:small"><i class="fa fa-clock-o fa-2x mt-1" aria-hidden="true"></i><br>Pending Approves</p></a>
    <?php 
    $nums=mysqli_num_rows($leave);
    if(mysqli_num_rows($leave)>0){
      echo  "<span class='position-relative top-10 start-40 translate-middle badge rounded-pill bg-danger' style='left:13px'>" .$nums;
    }
    ?>
  </div>
  <div class="content">
    <div class="row col-lg-15 " style="background-color:#354259;">
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
                <?php echo $row['first_name'].' '.$row['last_name'] ?> &nbsp<i class="fa fa-caret-down"></i></p>
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
    <div class="container-fluid mx-1">
        <div class="row h-100 w-100 justify-content-center">
            <div class="card h-100 " style="background-color: #ffffff74;">
              <div class="row justify-content-center">
                <div class="col">
                    <div class="card  rounded-3  " style=" background-color: #ffffff;margin:2% ">
              <div class="card-header mb-3" style="background-color:#ECE5C7 ";> 
                <h2 style="text-align: center; " class="md-5 mt-2">Enter employee details</h2>                 
                </div>
                <div class="card-body" style="padding:2%">
                  <form action="add_user_database.php" method="POST">
                <div class="row ">
                  <div class="col-md-6">
    
                    <h5 class="md-3">Personal details</h5>
                    <div class="md-3">
                      <div class="row">
                        <div class="col">
                          <input type="text" class="form-control" name="xxfname" placeholder="First name" required />
                        </div>
                        <div class="col">
                          <input type="text" class="form-control" name="xxlname" placeholder="Last name" required />
                        </div>
                      </div>
                      <input type="mail" style="margin-top: 10px" name="xxemail" placeholder="Email : saman@gmail.com" class="form-control" required />
                      <input type="text" style="margin-top: 10px" name="xxphone" placeholder="Phone : 0771234567" maxlength="10" minlength="10" class="form-control" required />
                      <input type="date" style="margin-top: 10px" name="xxbdate" class="form-control" max="<?php echo date("Y-m-d");?>" required />
                    </div>
                    <div class="row">
                      <div class="col">
                        <label style="margin-top: 10px" class="col-sm-7 control-label">Select Gender</label>
                        <div class="col-sm-8">
                          <label class="radio-inline">
                            <input type="radio" name="xxgender" value="male" required /> Male
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="xxgender" value="female" required /> Female
                          </label>
                        </div>
                      </div>
                      <div class="col">
                        <select class="form-select" name="xxmarital" style="margin-top:30px" required>
                          <option value="">Marital Status</option>
                          <option value="single">Single</option>
                          <option value="married">Married</option>
                          <option value="divorced">Divorced</option>
                          <option value="widowed">Widowed</option>
                        </select>
                      </div>
                    </div>
                    <label style="margin-top: 10px" class="col-sm-4 control-label">Address</label>
                    <div class="row g-3">
                      <div class="col">
                        <input style="margin-top:10px; margin-bottom:10px" type="text" class="form-control" name="xxadd1" placeholder="Address line 1" required />
                      </div>
                    </div>
                    <div class="row g-3">
                      <div class="col">
                        <input style="margin-bottom:10px" type="text" class="form-control" name="xxadd2" placeholder="Address line 2" required />
                      </div>
                    </div>
                    <div class="row g-3">
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="xxcity" placeholder="City" required />
                      </div>
                      <div class="col-sm-4">
                        <select class="form-select" name="xxprovince" required>
                          <option value="">Province</option>
                          <option value="Central">Central</option>
                          <option value="North Central">North Central</option>
                          <option value="Northern">Northern</option>
                          <option value="Eastern">Eastern</option>
                          <option value="North Western">North Western</option>
                          <option value="Southern">Southern</option>
                          <option value="Uva">Uva</option>
                          <option value="Southern">Southern</option>
                          <option value="Western">Western</option>
                        </select>
                      </div>
                      <div class="col-sm">
                        <input type="text" class="form-control" name="xxzip" placeholder="Zip" required />
                      </div>
                    </div>
    
                    <br />
    
                  </div>
                  <div class="col-md-6">
                    <h5 style="margin-top: 10px" class="md-3">Employment details</h5>
                    <div class="md-3">
                      <div class="row">
                        <div class="col">
                          <div class="col">
                            <select class="form-select" name="xxjtitle" required>
                              <option value="">Job Title</option>
                              <?php
                              $query = "SELECT DISTINCT * FROM job ORDER BY job_title";
                              $result = $conn->query($query);
                              if ($result->num_rows > 0) {
                                $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                              }
                              foreach ($options as $option) {
                              ?>
                                <option value="<?php echo $option['job_id']; ?>"><?php echo $option['job_title']; ?> </option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col">
                          <select class="form-select" name="xxdpt" required>
                            <option value="">Department</option>
                            <?php
                            $query = "SELECT DISTINCT name FROM department ORDER BY name ASC";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                              $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            }
                            foreach ($options as $option) {
                            ?>
                              <?php
                              $query2 = "SELECT DISTINCT id FROM department where name='" . $option['name'] . "'";
                              $dept = mysqli_query($conn, $query2);
                              $dept1 = mysqli_fetch_assoc($dept);
                              $dept_id = $dept1['id'];
                              ?>
                              <option value="<?php echo $dept_id; ?>"><?php echo $option['name']; ?> </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
    
                      <div style="margin-top: 2px" class="row g-3">
                        <div class="col">
                          <select class="form-select" name="xxpaygrade" required>
                            <option value="">Pay Grade</option>
                            <?php
                            $query = "SELECT DISTINCT * FROM pay_level ORDER BY pay_grade ASC";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                              $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            }
                            foreach ($options as $option) {
                            ?>
                              <option value="<?php echo $option['pay_grade']; ?>"><?php echo $option['title']; ?> </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col">
                          <select class="form-select" name="xxstatus" required>
                            <option value="">Status</option>
                            <?php
                            $query = "SELECT * FROM emp_status ORDER BY stat_id ASC";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                              $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            }
                            foreach ($options as $option) {
                            ?>
                              <option value="<?php echo $option['stat_id']; ?>"><?php echo $option['title']; ?> </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="row g-3" style="margin-top: 0.5px;">
                        <div class="col">
                        <select class="form-select" name="xxsid" required>
                            <option value="">Supervisor</option>
                            <?php
                            $query = "SELECT * FROM employee ORDER BY first_name,last_name";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                              $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            }
                            foreach ($options as $option) {
                            ?>
                              <option value="<?php echo $option['id']; ?>"><?php echo $option['first_name'].' '.$option['last_name']; ?> </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
    
                    <h5 style="margin-top: 10px" class="md-3">Account details</h5>
                    <div class="md-3">
                      <div class="row">
                        <div class="col">
                          <input type="text" class="form-control" name="xxbnkname" placeholder="Bank name" required />
                        </div>
                        <div class="col">
                          <input type="text" class="form-control" name="xxbrnchname" placeholder="Branch name" required />
                        </div>
                      </div>
                      <input type="text" style="margin-top: 10px" name="xxaccn" placeholder="Account Number" class="form-control" required />
                      <div class="md-3">
                        <?php
                        $query = "SELECT * FROM custom_attribute";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                          echo "<h5 style='margin-top: 10px' class='md-3'>Other Informations</h5>";
                          $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                          foreach ($options as $option) {
                            $attr_name=$option['name'];
                            $attr_namexx='xx'.$attr_name;
                            echo "<input style='margin-top: 10px' type='text' class='form-control' name='$attr_namexx' placeholder='$attr_name' required />"
                            ?>
                          <?php
                          }
                        }
                        ?>
                      <div>
                    </div>
                      
                  </div>
                </div>
                <div class="row">
                  <div class="col text-center mt-2">
                    <input class="btn btn-primary" type="submit" value="Send" />
                  </div>
                </div>
              </form>
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
>>>>>>> Stashed changes:jupiter/add_new_employee.php
</html>