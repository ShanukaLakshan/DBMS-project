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
    $id=$row2['id'];
    $get_leaves = "select * FROM leave_requests WHERE id in (SELECT id FROM supervisor where supervisor_id = '$id') and status='pending'";
    $leaves = mysqli_query($conn, $get_leaves);
    $sql3 = mysqli_query($conn,"SELECT * FROM employment WHERE id='$id'");
    $row4 = mysqli_fetch_array($sql3);
    $jobid=$row4['job_id'];
    $jobq=mysqli_query($conn,"SELECT * FROM job WHERE job_id='$jobid'");
    $job=mysqli_fetch_array($jobq);
    $get_leaves = "select id FROM leave_requests WHERE id in (SELECT id FROM supervisor where supervisor_id = '$id') and status='pending'";
    $leave = mysqli_query($conn, $get_leaves);
} catch (Exception $e) {
    echo "<p style='color:red;'>Username or Password is incorrect !</p>";
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title> Jupiter - Account Details</title>
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

    .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        transition: .5s ease;
        background-color: #6356666f;
    }

    .container:hover .overlay {
        opacity: 1;
    }
    .form-div {
  margin-top: 100px;
  border: 1px solid #e0e0e0;
    }
    #profileDisplay {
    display: block;
    height: 300px;
    width:300px;
    margin: 0px auto;
    border-radius: 0%;
    }
    .img-placeholder {
    width: 46%;
    color: white;
    height: 100%;
    background: black;
    opacity: 0.7;
    border-radius: 0%;
    z-index: 2;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    display: none;
    }
    .img-placeholder h4 {
    margin-top: 40%;
    color: white;
    }
    .img-div:hover .img-placeholder {
    display: block;
    cursor: pointer;
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
        <?php if ($job['job_title'] === 'HR Manager') { ?>
      <a href="../jupyter/add_new_employee.php">Add New Employee</a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Add New Employee</a>
  <?php } ?>
        <a href="../jupyter/leaveform.php">Request a Leave</a>
        <?php if ($job['job_title'] === 'HR Manager') { ?>
    <a href="../jupyter/reports.php" >Reports</a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Reports</a>
  <?php } ?>
        <a href="../jupyter/approve_leaves.php">Pending Approvals</a>
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
                                <a href="#">Account details</a>
                                <a href="../jupyter/logout.php">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="container-fluid mx-0">
            <div class="card">
                <form action="update.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <h2 class="text-center mb-3 mt-3">Update profile</h2>
                        <div class="col">
                        <?php if (!empty($msg)) : ?>
                        <div class="alert <?php echo $msg_class ?>" role="alert">
                            <?php echo $msg; ?>
                        </div>
                        <?php endif; ?>
                        <div class="form-group text-center" style="position: relative;">
                            <span class="img-div">
                                <div class="text-center img-placeholder" onClick="triggerClick()">
                                </div>
                                <div class="container" style="position: relative;">
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
                                              }                                            ?>
                                    </div>
                            </span>
                            <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage"
                                class="form-control" style="display: none;">
                        </div>
                        </div>
                        <div class="col">
                            <div class="row m-2">
                                <label>New Username</label>
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="uname"
                                        placeholder="Change Username"
                                        aria-label="Change Username"
                                    />
                                </div>
                                
                            </div>
                            <div class="row m-2">
                                <label>Current Password</label>
                                <div class="form-group">
                                    <input
                                type="password"
                                class="form-control"
                                name="pass"
                                placeholder="Current Password"
                                aria-label="Current Password"
                              />
                                </div>
                            </div>
                            <div class="row m-2">
                                <label>New Password</label>
                                <div class="form-group">
                                    <input
                                type="password"
                                class="form-control"
                                name="pass-1"
                                placeholder="Change Password"
                                aria-label="Change Password"
                              />
                                </div>
                            </div>
                            <div class="row m-2">
                                <div class="form-group">
                                    <input
                                type="password"
                                class="form-control"
                                name="pass-2"
                                placeholder="Confirm Password"
                                aria-label="Confirm Password"
                              />
                              <p style="color:#ff0000;margin-top: 2%;"><?php
                                    if(isset($_REQUEST["pass"]))
                                        echo "Passwords do not match";
                                    ?></p>
                            <p style="color:#ff0000;margin-top: 2%;"><?php
                                if(isset($_REQUEST["passl"]))
                                    echo "Passwords is too short";
                                ?></p>
                                <p style="color:#ff0000;margin-top: 2%;"><?php
                                    if(isset($_REQUEST["user"]))
                                        echo "Username is already taken";
                                    ?></p>
                                    <p style="color:#ff0000;margin-top: 2%;"><?php
                                    if(isset($_REQUEST["error"]))
                                        echo "Incorrect Password!";
                                    ?></p>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
        <div class="row justify-content-center" style="margin-top:5%">
            <div class="col-auto">
                <div class="form-group">
                    <button type="submit" name="save_profile" class="btn btn-primary btn-block" style="margin-bottom:5%">Save Changes</button>
                </div>
            </div>
            
        </div>
        </form>
            </div>
                    
        </div>
    </div>
    </div>

    </div>
</body>
<script src="script.js"></script>
</html>
