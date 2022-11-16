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

    $sql1 = mysqli_query($conn, "SELECT * FROM employee WHERE id in (SELECT id FROM user WHERE user_name = '$username' AND password = '$userpassword')");
    $row = mysqli_fetch_array($sql1);

    $id=$row['id'];

    $get_leaves = "select id FROM leave_requests WHERE id in (SELECT id FROM supervisor where supervisor_id = '$id') and status='pending'";
    $leave = mysqli_query($conn, $get_leaves);

    $sql3 = mysqli_query($conn,"SELECT * FROM employment WHERE id='$id'");
    $row4 = mysqli_fetch_array($sql3);
    $jobid=$row4['job_id'];
    $jobq=mysqli_query($conn,"SELECT * FROM job WHERE job_id='$jobid'");
    $job=mysqli_fetch_array($jobq);

if(empty($_POST['dpt']) && empty($_POST['jid']) && empty($_POST['pay_grade'])){
  $msg="All Employees";
  $empq= "SELECT * FROM employee";
}
else{
    $msg="Employees By ";
    $empq = "SELECT * FROM employee WHERE id in (select id from employment where dept_id=dept_id ";

if(!empty($_POST['dpt'])){
  $dept_id=$_POST['dpt'];
  $sql10=mysqli_query($conn,"SELECT * FROM department WHERE id='$dept_id'");
  $dept=mysqli_fetch_array($sql10);
  $msg .= "Department: ".$dept['name']." ";
  $empq .= "AND dept_id=".$_POST['dpt']." ";
}
if(!empty($_POST['jid'])){
  $msg .= "Job Title: ".mysqli_fetch_array(mysqli_query($conn,"select * from job where job_id=".$_POST['jid']." "))['job_title']." ";
  $jobt=$_POST['jid'];
  $empq .= "AND job_id='$jobt' ";
}
if(!empty($_POST['pay_grade'])){
  $msg .= "Pay Grade: ".$_POST['pay_grade']." ";
  $empq .= "AND pay_grade=".$_POST['pay_grade']." ";
}
$empq .= ")";
}

$emps=mysqli_query($conn,$empq);

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <title>Jupiter - Reports - Menu</title>
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
  body {
        background: #6ae98a;
        background: -webkit-radial-gradient(top right, #6ae98a, #7cb8e9);
        background: -moz-radial-gradient(top right, #6ae98a, #7cb8e9);
        background: radial-gradient(to bottom left, #6ae98a, #7cb8e9);
    }

    .wrapper {
        margin: 10vh
    }

    .card {
        border: none;
        transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
        overflow: hidden;
        border-radius: 20px;
        min-height: 450px;
        box-shadow: 0 0 12px 0 rgba(0, 0, 0, 0.2);

        @media (max-width: 768px) {
            min-height: 350px;
        }

        @media (max-width: 420px) {
            min-height: 300px;
        }

        &.card-has-bg {
            transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
            background-size: 120%;
            background-repeat: no-repeat;
            background-position: center center;

            &:before {
                content: '';
                position: absolute;
                top: 0;body {
        background: #6ae98a;
        background: -webkit-radial-gradient(top right, #6ae98a, #7cb8e9);
        background: -moz-radial-gradient(top right, #6ae98a, #7cb8e9);
        background: radial-gradient(to bottom left, #6ae98a, #7cb8e9);
    }

    .wrapper {
        margin: 10vh
    }

    .card {
        border: none;
        transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
        overflow: hidden;
        border-radius: 20px;
        min-height: 450px;
        box-shadow: 0 0 12px 0 rgba(0, 0, 0, 0.2);

        @media (max-width: 768px) {
            min-height: 350px;
        }

        @media (max-width: 42
                right: 0;
                bottom: 0;
                left: 0;
                background: inherit;
                -webkit-filter: grayscale(1);
                -moz-filter: grayscale(100%);
                -ms-filter: grayscale(100%);
                -o-filter: grayscale(100%);
                filter: grayscale(100%);
            }

            &:hover {
                transform: scale(0.98);
                box-shadow: 0 0 5px -2px rgba(0, 0, 0, 0.3);
                background-size: 130%;
                transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);

                .card-img-overlay {
                    transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
                    background: rgb(35, 79, 109);
                    background: linear-gradient(0deg, rgba(4, 69, 114, 0.5) 0%, rgba(4, 69, 114, 1) 100%);
                }
            }
        }

        .card-footer {
            background: none;
            border-top: none;

            .media {
                img {
                    border: solid 3px rgba(255, 255, 255, 0.3);
                }
            }
        }

        .card-meta {
            color: #26BD75
        }

        .card-body {
            transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
        }

        &:hover {
            .card-body {
                margin-top: 30px;
                transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
            }

            cursor: pointer;
            transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
        }

        .card-img-overlay {
            transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
            background: rgb(35, 79, 109);
            background: linear-gradient(0deg, rgba(35, 79, 109, 0.3785889355742297) 0%, rgba(69, 95, 113, 1) 100%);
        }
    }

    @media (max-width: 767px) {}
</style>

<body>

  <div class="sidebar">
    <a href="./homepage.php">Home</a>
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
    <a class="active" href="./reports.php" >Reports</a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Reports</a>
  <?php } ?>
    <a href="./approve_leaves.php" style="position:relative">Pending Approvals</a>
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
    <div class="container-fluid mx-0">
      <div class="row card align-content-center justify-content-center" style="margin: 30px; min-height: 80vh;">
            <div class="card-header text-center">
                    <h1 class="display-4">Reports</h1>
                    <p class="lead">You can get any report from here. </p>
            </div>
            <div class="card-body mt-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="card text-white card-has-bg click-col" style="background-image:url('employee.jpeg');">
                        <img class="card-img d-none" alt="Goverment Lorem Ipsum Sit Amet Consectetur dipisi?">
                        <div class="card-img-overlay d-flex flex-column">
                            <div class="card-body">
                                <small class="card-meta mb-2">Thought Leadership</small>
                                <h2 class="card-title mt-0" style="padding-top: 50px; padding-bottom: 50px;"><a href="www.google.com" class="text-black">Employee
                                        Reports</a></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="card text-white card-has-bg click-col" style="background-image:url('leave.jpg');">
                        <img class="card-img d-none" alt="Goverment Lorem Ipsum Sit Amet Consectetur dipisi?">
                        <div class="card-img-overlay d-flex flex-column">
                            <div class="card-body">
                                <small class="card-meta mb-2">Thought Leadership</small>
                                <h2 class="card-title mt-0 " style="padding-top: 50px; padding-bottom: 50px;"><a href="www.google.com" class="text-black">Leave
                                        Reports</a></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="card text-white card-has-bg click-col" style="background-image:url('custom.webp');">
                        <img class="card-img d-none" alt="Goverment Lorem Ipsum Sit Amet Consectetur dipisi?">
                        <div class="card-img-overlay d-flex flex-column">
                            <div class="card-body">
                                <small class="card-meta mb-2">Thought Leadership</small>
                                <h2 class="card-title mt-0 " style="padding-top: 50px; padding-bottom: 50px;"><a href="www.google.com" class="text-black">Custom
                                        Reports</a></h2>
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