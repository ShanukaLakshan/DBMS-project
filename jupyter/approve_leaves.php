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
} catch (Exception $e) {
    echo "<p style='color:red;'>Username or Password is incorrect !</p>";
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title> Jupiter - Approve Leaves</title>
    <link rel="icon" type="image/x-icon" href="./img/favicon.png" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>body {
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
  .btn-sq{
    border-radius: 0px;
    background-color:#CDC2AE;
    height: 82px !important;
    width: 100px !important;
  }
  .btn:hover{
    background-color: #354259;
    border-radius:10%;
    color:white
  }
  .btn-success{
    background-color: #65C18C;
    border-radius:10%;
    color:white;
    border-color: #65c18b;
    height:30px;
    font-size:medium;
    padding: 5%;
    width: 50px;
  }
  .btn-danger{
    background-color: #FF4A4A;
    border-radius:10%;
    color:white;
    border-color: #FF4A4A;
    height:30px;
    font-size:medium;
    padding: 5%;
    width: 50px;
  }
  </style>
<body>
    <div class="sidebar">
    <a  href="../jupyter/homepage.php">Home</a>
  <?php if ($row2['user_type'] === 'admin') { ?>
      <a href="../jupyter/review_employee.php">Review Employees</a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Review Employees</a>
  <?php } ?>
  <?php if ($jobid === '004') { ?>
      <a href="../jupyter/add_new_employee.php">Add New Employee</a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Add New Employee</a>
  <?php } ?>

    <a href="../jupyter/leaveform.php" >Request a Leave</a>


  <?php if ($jobid === '004') { ?>
    <a href="../jupyter/reports.php" >Reports</a>
    <?php } else { ?>
      <a href="#" style="display: none;" >Reports</a>
  <?php } ?>
  <a class="active" class="active" href="../jupyter/approve_leaves.php">Pending Approvals</a>
    
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
                        <button class="dropbtn align-self-end"> <p style="color:white">
                          <?php echo $row['name'] ?> &nbsp<i class="fa fa-caret-down"></i></p>
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
        <div class="container-fluid mx-0"  >
                <div class="card" style="background-color: #eeedde78;padding: 2%;min-height: 85vh;margin-top: 1%;">
                    <div class="p-2 justify-content-center">
                        <?php
                        if (mysqli_num_rows($leaves) > 0) { ?>
        
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <div class="card" style="background-color: #EEEDDE;">
                                        <div class="card-header">
                                            <h5>Pending Approvals</h5>
                                        <table class="table justify-content-center" style="width: auto;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <td>ID</td>
                                                    <td>Name</td>
                                                    <td>Type</td>
                                                    <td>Date</td>
                                                    <td>Status</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($leaves)) { ?>
                                                    <tr>
                                                        <th scope="row"><?= $i ?></th>
                                                        <td><?php echo $row["id"]; ?></td>
                                                        <td><?php echo mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM employee WHERE id=".$row["id"].""))['name']; ?></td>                                                        <td><?php echo mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM leave_type WHERE type_id=".$row["type_id"].""))['name']; ?></td>
                                                        <td><?php echo $row["date_of_leave"]; ?></td>
                                                        <td><?php echo $row["status"]; ?></td>
                                                        <form action="approved.php" method="get">
                                                            <input type="text" name="get_username" value="<?php echo $us_name ?>" style="display: none;" />
                                                            <input type="text" name="date" value="<?php echo $row["date_of_leave"]; ?>" style="display: none;" />
                                                            <input type="text" name="id" value="<?php echo $row["id"]; ?>" style="display: none;" />
                                                            <td><button type="submit" name='data' value='1' class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button></td>
                                                        </form>
                                                        <form action="declined.php" method="get">
                                                            <input type="text" name="get_username" value="<?php echo $us_name ?>" style="display: none;" />
                                                            <input type="text" name="date" value="<?php echo $row["date_of_leave"]; ?>" style="display: none;" />
                                                            <input type="text" name="id" value="<?php echo $row["id"]; ?>" style="display: none;" />
                                                        <td><button type='submit' class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                                        </form>
                                                    </tr>
                                                <?php $i++;
                                                } 
                                                ?>
                                                <? if(empty($row)){
                                                    echo "lol bn";
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                
                            </div>
        
                        <?php } 
                        else{
                          echo "<h3 class='text-center'>No Pending Approvals</h3>";
                        }?>
                    </div>
                </div>
        </div>
            
    </div>
</body>

</html>