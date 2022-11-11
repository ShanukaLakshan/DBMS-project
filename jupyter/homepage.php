<?php
include('user_config.php');
include('db_connector.php');
$username = "" . $_POST['uname'];
$userpassword = "" . $_POST['pwd'];

try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
    $get_leaves = "select id FROM leave_request WHERE id in (SELECT id FROM supervisor where supervisor_id = '$username') and status='pending'";
    $leaves = mysqli_query($conn, $get_leaves);
} catch (Exception $e) {
    echo "<p style='color:red;'>Database Connection Failed !</p>";
    exit();
}

try {
    $sql2 = mysqli_query($conn, "SELECT * FROM user WHERE id = '$username' AND password = '$userpassword'");
    $row2 = mysqli_fetch_array($sql2);

    $sql1 = mysqli_query($conn, "SELECT * FROM employee WHERE id in (SELECT id FROM user WHERE id = '$username' AND password = '$userpassword')");
    $row = mysqli_fetch_array($sql1);

    $sql3 = mysqli_query($conn,"SELECT * FROM employment WHERE id='$username'");
    $row4 = mysqli_fetch_array($sql3);

    $sql4 = mysqli_query($conn,"SELECT * FROM address WHERE id='$username'");
    $row5 = mysqli_fetch_array($sql4);

    $sql5 = mysqli_query($conn,"SELECT count(id) as count FROM leave_request WHERE id='$username' and status='approved' and type='casual'");
    $casualc=mysqli_fetch_array($sql5);

    $sql6 = mysqli_query($conn,"SELECT count(id) as count FROM leave_request WHERE id='$username' and status='approved' and type='anual'");
    $annualc=mysqli_fetch_array($sql6);

    $sql7 = mysqli_query($conn,"SELECT count(id) as count FROM leave_request WHERE id='$username' and status='approved' and type='maternity'");
    $maternityc=mysqli_fetch_array($sql7);

    $sql8 = mysqli_query($conn,"SELECT count(id) as count FROM leave_request WHERE id='$username' and status='approved' and type='no_pay'");
    $nopayc=mysqli_fetch_array($sql8);

    $sql9 = mysqli_query($conn,"SELECT * FROM leave_detail WHERE job_title='$row4[job_title]'");
    $leaves=mysqli_fetch_array($sql9);

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
  <title>Document</title>
</head>
<style>
  body {
    background-color: #2C3333;
  }

  /* The side navigation menu */
  .sidebar {
    margin: 0;
    padding: 0;
    width: 100px;
    background-color: #f1f1f1;
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
    background-color: #395B64;
    color: white;
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
    background-color: #395B64;
    
  }
</style>

<body>

  <div class="sidebar">
    <a class="active" href="#home">Home</a>
    <a href="#contact">Pending approvals</a>
    <a href="#about">Request a leave</a>
  </div>
  <div class="content">
    <div class="row col-lg-15 " style="background-color:#E7F6F2">
      <div class="col">
        <img class="border-dark " src="./img/jupiter_logo.png"
          style="width:250px;margin-bottom: 5px;margin-left: 10px;">
      </div>
      <div class="col-lg-6 align-self-center text-center">
        <h4 style="color:rgb(0, 0, 0)">Jupiter Employee Portal</h4>
      </div>
      <div class="col-sm-3 align-self-lg-center d-flex justify-content-end">
        <div class="row mx-0 text-end">
          <div class="col-auto text-end">
            <?php
                $sql3 = mysqli_query($conn, "SELECT * FROM user WHERE id = '$username'");
                $row3 = mysqli_fetch_array($sql3);
                $name = $row2['img_name'];
                $stmt = $pdo->prepare("SELECT `img_data` FROM `user` WHERE `img_name`=?");
                $stmt->execute([$name]);
                $img = $stmt->fetch();
                $img = $img["img_data"];
                $img = base64_encode($img);
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                echo "<img src='data:image/" . $ext . ";base64," . $img . "' height='auto' width='30px' class='rounded-circle' alt='...'/>";
                ?>

          </div>
          <div class="col-lg-auto text-end align-content-end" style="margin-left:-4%;">
            <div class="dropdown align-self-end" style="float:right">
              <button class="dropbtn align-self-end">
                <?php echo $row['name'] ?> &nbsp<i class="fa fa-caret-down"></i>
              </button>
              <div class="dropdown-content" style="left:0px">
                <a href="#">Account details</a>
                <a href="#">Logout</a>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    <div class="container-fluid mx-0">
      <div class="row" style="margin-top:1%">
        <div class="col">
          <div class="card rounded-3" style="padding: 2%;background-color: rgba(255, 255, 255, 0.2);">
            <div class="row">
              <div class="col justify-content-md-start">
                <div class="card" style="padding:2%">
                  <div class="text-center">
                    <?php
                                        $sql3 = mysqli_query($conn, "SELECT * FROM user WHERE id = '$username'");
                                        $row3 = mysqli_fetch_array($sql3);
                                        $name = $row2['img_name'];
                                        $stmt = $pdo->prepare("SELECT `img_data` FROM `user` WHERE `img_name`=?");
                                        $stmt->execute([$name]);
                                        $img = $stmt->fetch();
                                        $img = $img["img_data"];
                                        $img = base64_encode($img);
                                        $ext = pathinfo($name, PATHINFO_EXTENSION);
                                        echo "<img class='border border-primary rounded-circle' src='data:image/" . $ext . ";base64," . $img . "' alt='user image' style='width: 300px; height: 300px;'/>";
                                        ?>

                    <h5 class="card-title fw-bold" style="margin-top: 10px;">
                      <?php echo $row['name'] ?>
                    </h5>
                    <h6 class="card-title" style="margin-top: -5px;">
                      <?php echo $username ?>
                    </h6>
                  </div>
                  <div class="container-fluid">
                    <div class="row justify-content-center " style="margin-top:10px;">
                      <div class="col col-sm-4 align-self-center">
                        <p style="color: #858585; margin-bottom: 2px;">Gender</p>
                        <p>
                          <?php echo $row['gender'] ?>
                        </p>
                      </div>
                      <div class="col col-sm-4 align-self-center">
                        <p style="color: #858585; margin-bottom: 2px;">Martial Status</p>
                        <p>
                          <?php echo $row['marital_status'] ?>
                        </p>
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col col-sm-4 ">
                        <p style="color: #858585; margin-bottom: 2px;">Address</p>
                        <p>
                          <?php echo $row5['address_line_1'].','.$row5['address_line_2'] ?>
                        </p>
                        <p style="margin-top:-10%">
                          <?php echo $row5['city'].','.$row5['postal_code'] ?>
                        </p>
                      </div>
                      <div class="col col-sm-4">
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
                  <div class="card" style="background-color:#E7F6F2">
                    <div class="card-header">
                      <p class="fw-bold" style="font-size:large">Employment</p>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col col-sm-4">
                          <p style="color: #858585; margin-bottom: 2px;">Department</p>
                          <p>
                            <?php echo $row4['department'] ?>
                          </p>
                        </div>
                        <div class="col col-sm-4">
                          <p style="color: #858585; margin-bottom: 2px;">Designation</p>
                          <p>
                            <?php echo $row4['job_title'] ?>
                          </p>
                        </div>
                        <div class="col col-sm-4">
                          <p style="color: #858585; margin-bottom: 2px;">Status</p>
                          <p>
                            <?php echo $row4['employement_status'] ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row align-self-center  " style="margin-top:10px">
                  <div class="card">
                    <div class="card-header" >
                      <p class="fw-bold" style="font-size:large">Leaves</p>
                    </div>
                    <div class="card-body">
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
      </div>
    </div>


</body>

</html>