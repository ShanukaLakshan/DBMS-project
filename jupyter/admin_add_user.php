<<<<<<< Updated upstream:jupyter/admin_add_user.php
<?php
include('admin_config.php');

$conn = mysqli_connect($sname, $uname, $password, $db_name);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <link rel="stylesheet" href="style.css" />
  <title>Jupiter - Register</title>
  <link rel="icon" type="image/x-icon" href="./img/favicon.png">
  <style>
    body {
      background-image: url(./img/rbackground.jpg);
      background-size: 100%;
      background-position: 10%;
    }

    .ca {
      font-size: 14px;
      display: inline-block;
      padding: 10px;
      text-decoration: none;
      color: #444;
    }

    .ca:hover {
      text-decoration: underline;
    }

    .btn-primary {
      color: white;
      background-color: rgba(210, 147, 94);
      border-color: rgba(210, 147, 94, 0.7);
    }

    .btn-primary:hover {
      color: white;
      background-color: rgb(169, 118, 77);
      border-color: rgb(169, 118, 77);
    }

    .btn-primary:active {
      color: #212529;
      background-color: rgb(204, 119, 149);
      border-color: #c25b76;
    }

    .btn-primary:disabled {
      color: #212529;
      background-color: #c3e6cb !important;
      border-color: #c3e6cb;
    }

    .btn-primary:focus {
      box-shadow: 0 0 0 0.2rem rgb(169, 118, 77);
      background-color: rgb(236, 162, 102) !important;
      border-color: rgb(236, 162, 102) !important;
      box-shadow: #723d00 !important;
      outline: #c25b76 !important;
    }

    .btn-outline-warning {
      color: #212529 !important;
      border-color: #6F1D1B;
    }

    .btn-outline-warning:hover {
      color: #ffffff !important;
      background-color: #6F1D1B;
      border-color: #6F1D1B;
    }

    .border-primary {
      border-color: #6F1D1B !important;
    }

    .form-control {
      background-color: rgba(255, 255, 255, 0.5);
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.2rem #6f1c1b70;
    }

    .form-select {
      background-color: rgba(255, 255, 255, 0.5);
    }

    .form-select:focus {
      box-shadow: 0 0 0 0.2rem #6f1c1b70;
    }

    .btn-danger {
      background-color: #9e2725 !important;
      border-color: #9e2725 !important;

    }

    .btn-danger:hover {
      color: #ffffff !important;
      background-color: #6F1D1B !important;
      border-color: #6F1D1B !important;
    }
  </style>
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center">
    <div class="row align-items-center " style="min-height: 100vh">
      <div class="col-md-12">
        <div class="card border-dark rounded-3 " style="width: 50rem; background-color: #ffffff68;padding: 2%; ">
          <div class="row">
            <div class="col">
              <h1 style="margin-bottom: 20px" class="md-5">Filled
                <?php echo $_GET['xfname']; ?>'s details
              </h1>
            </div>
          </div>
          <form method="POST" class="border shadow p-3 rounded" action="add_user_database.php">
            <div class="row ">
              <div class="col-md-6">

                <h5 class="md-3">Personal details</h5>
                <div class="md-3">
                  <div class="row">
                    <div class="col">
                      <input type="text" style="margin-top: 1px" class="form-control" name="xxfname" value="<?php echo $_GET['xfname']; ?>" readonly>
                    </div>
                    <div class="col">
                      <input type="text" style="margin-top: 1px" class="form-control" name="xxlname" value="<?php echo $_GET['xlname']; ?>" readonly>
                    </div>
                  </div>
                  <input type="mail" style="margin-top: 5px" class="form-control" name="xxemail" value="<?php echo $_GET['xemail']; ?>" readonly>
                  <input type="text" style="margin-top: 5px" class="form-control" name="xxphone" value="<?php echo $_GET['xphone']; ?>" readonly>
                  <input type="text" style="margin-top: 5px" class="form-control" name="xxbdate" value="<?php echo $_GET['xbdate']; ?>" readonly>
                </div>
                <div class="row">
                  <div class="col">
                    <label style="margin-top: 10px" class="col-sm-7 control-label">Gender</label>
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxgender" value="<?php echo $_GET['xgender']; ?>" readonly>
                  </div>
                  <div class="col">
                    <p style="margin: 0" style="font-size: 3px;">Marital Status</p>
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxmarital" value="<?php echo $_GET['xmarital']; ?>" readonly>
                  </div>
                </div>
                <label style="margin-top: 10px" class="col-sm-4 control-label">Address</label>
                <div class="row g-3">
                  <div class="col">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxadd1" value="<?php echo $_GET['xadd1']; ?>" readonly>
                  </div>
                </div>
                <div class="row g-3">
                  <div class="col">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxadd2" value="<?php echo $_GET['xadd2']; ?>" readonly>
                  </div>
                </div>
                <div class="row g-3">
                  <div class="col-sm-5">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxcity" value="<?php echo $_GET['xcity']; ?>" readonly>
                  </div>
                  <div class="col-sm-4">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxprovince" value="<?php echo $_GET['xprovince']; ?>" readonly>
                  </div>
                  <div class="col-sm">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxzip" value="<?php echo $_GET['xzip']; ?>" readonly>
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
                        <p style="margin: 0" style="font-size: 3px;">Designation</p>
                        <input type="text" class="form-control" name="xxjtitle" value="<?php echo $_GET['xjtitle']; ?>" readonly>
                      </div>
                    </div>
                    <div class="col">
                      <?php
                      $query2 = "SELECT name FROM department where id='" . $_GET['xdpt'] . "'";
                      $dept = mysqli_query($conn, $query2);
                      $dept1 = mysqli_fetch_assoc($dept);
                      $dept_name = $dept1['name'];
                      ?>
                      <p style="margin: 0" style="font-size: 3px;">Department</p>
                      <input type="text" class="form-control" name="xxdpt" value="<?php echo $dept_name; ?>" readonly>
                    </div>
                  </div>

                  <div class="row g-3">
                    <div class="col">
                      <p style="margin: 0" style="font-size: 3px;">Paygrade</p>
                      <input type="text" class="form-control" name="xxpaygrade" value="<?php echo $_GET['xpaygrade']; ?>" readonly>
                    </div>
                    <div class="col">
                      <p style="margin: 0" style="font-size: 3px;">Status</p>
                      <input type="text" class="form-control" name="xxstatus" value="<?php echo $_GET['xstatus']; ?>" readonly>
                    </div>
                  </div>
                  <div class="row g-3" style="margin-top: 0.5px;">
                    <div class="col">
                      <p style="margin: 0;color:red">Supervisor ID</p>
                      <input type="text" class="form-control" name="xxsid" placeholder="Supervisor ID" required>
                    </div>
                  </div>
                </div>

                <h5 style="margin-top: 10px" class="md-3">Account details</h5>
                <div class="md-3">
                  <div class="col">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxbnkname" value="<?php echo $_GET['xbnkname']; ?>" readonly>
                  </div>
                  <div class="col">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxbrnchname" value="<?php echo $_GET['xbrnchname']; ?>" readonly>
                  </div>
                </div>
                <input type="text" style="margin-top: 5px" class="form-control" name="xxaccn" value="<?php echo $_GET['xaccn']; ?>" readonly>
              </div>
              <div class="row">
                <div class="col text-center">
                  <input style="margin: 10px" class="btn btn-primary " type="submit" value="Approve">
                </div>
              </div>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</body>

=======
<?php
include('admin_config.php');

$conn = mysqli_connect($sname, $uname, $password, $db_name);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <link rel="stylesheet" href="style.css" />
  <title>Jupiter - Register</title>
  <link rel="icon" type="image/x-icon" href="./img/favicon.png">
  <style>
    body {
      background-image: url(./img/rbackground.jpg);
      background-size: 100%;
      background-position: 10%;
    }

    .ca {
      font-size: 14px;
      display: inline-block;
      padding: 10px;
      text-decoration: none;
      color: #444;
    }

    .ca:hover {
      text-decoration: underline;
    }

    .btn-primary {
      color: white;
      background-color: rgba(210, 147, 94);
      border-color: rgba(210, 147, 94, 0.7);
    }

    .btn-primary:hover {
      color: white;
      background-color: rgb(169, 118, 77);
      border-color: rgb(169, 118, 77);
    }

    .btn-primary:active {
      color: #212529;
      background-color: rgb(204, 119, 149);
      border-color: #c25b76;
    }

    .btn-primary:disabled {
      color: #212529;
      background-color: #c3e6cb !important;
      border-color: #c3e6cb;
    }

    .btn-primary:focus {
      box-shadow: 0 0 0 0.2rem rgb(169, 118, 77);
      background-color: rgb(236, 162, 102) !important;
      border-color: rgb(236, 162, 102) !important;
      box-shadow: #723d00 !important;
      outline: #c25b76 !important;
    }

    .btn-outline-warning {
      color: #212529 !important;
      border-color: #6F1D1B;
    }

    .btn-outline-warning:hover {
      color: #ffffff !important;
      background-color: #6F1D1B;
      border-color: #6F1D1B;
    }

    .border-primary {
      border-color: #6F1D1B !important;
    }

    .form-control {
      background-color: rgba(255, 255, 255, 0.5);
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.2rem #6f1c1b70;
    }

    .form-select {
      background-color: rgba(255, 255, 255, 0.5);
    }

    .form-select:focus {
      box-shadow: 0 0 0 0.2rem #6f1c1b70;
    }

    .btn-danger {
      background-color: #9e2725 !important;
      border-color: #9e2725 !important;

    }

    .btn-danger:hover {
      color: #ffffff !important;
      background-color: #6F1D1B !important;
      border-color: #6F1D1B !important;
    }
  </style>
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center">
    <div class="row align-items-center " style="min-height: 100vh">
      <div class="col-md-12">
        <div class="card border-dark rounded-3 " style="width: 50rem; background-color: #ffffff68;padding: 2%; ">
          <div class="row">
            <div class="col">
              <h1 style="margin-bottom: 20px" class="md-5">Filled
                <?php echo $_GET['xfname']; ?>'s details
              </h1>
            </div>
          </div>
          <form method="POST" class="border shadow p-3 rounded" action="add_user_database.php">
            <div class="row ">
              <div class="col-md-6">

                <h5 class="md-3">Personal details</h5>
                <div class="md-3">
                  <div class="row">
                    <div class="col">
                    <input type="text" style="display:none" class="form-control" name="flag" value="1" readonly>
                      <input type="text" style="margin-top: 1px" class="form-control" name="xxfname" value="<?php echo $_GET['xfname']; ?>" readonly>
                    </div>
                    <div class="col">
                      <input type="text" style="margin-top: 1px" class="form-control" name="xxlname" value="<?php echo $_GET['xlname']; ?>" readonly>
                    </div>
                  </div>
                  <input type="mail" style="margin-top: 5px" class="form-control" name="xxemail" value="<?php echo $_GET['xemail']; ?>" readonly>
                  <input type="text" style="margin-top: 5px" class="form-control" name="xxphone" value="<?php echo $_GET['xphone']; ?>" readonly>
                  <input type="text" style="margin-top: 5px" class="form-control" name="xxbdate" value="<?php echo $_GET['xbdate']; ?>" readonly>
                </div>
                <div class="row">
                  <div class="col">
                    <label style="margin-top: 10px" class="col-sm-7 control-label">Gender</label>
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxgender" value="<?php echo $_GET['xgender']; ?>" readonly>
                  </div>
                  <div class="col">
                    <p style="margin: 0" style="font-size: 3px;">Marital Status</p>
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxmarital" value="<?php echo $_GET['xmarital']; ?>" readonly>
                  </div>
                </div>
                <label style="margin-top: 10px" class="col-sm-4 control-label">Address</label>
                <div class="row g-3">
                  <div class="col">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxadd1" value="<?php echo $_GET['xadd1']; ?>" readonly>
                  </div>
                </div>
                <div class="row g-3">
                  <div class="col">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxadd2" value="<?php echo $_GET['xadd2']; ?>" readonly>
                  </div>
                </div>
                <div class="row g-3">
                  <div class="col-sm-5">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxcity" value="<?php echo $_GET['xcity']; ?>" readonly>
                  </div>
                  <div class="col-sm-4">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxprovince" value="<?php echo $_GET['xprovince']; ?>" readonly>
                  </div>
                  <div class="col-sm">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxzip" value="<?php echo $_GET['xzip']; ?>" readonly>
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
                        <p style="margin: 0" style="font-size: 3px;">Designation</p>
                        <input type="text" class="form-control" name="xxjtitle" value="<?php echo $_GET['xjtitle']; ?>" readonly>
                      </div>
                    </div>
                    <div class="col">
                      <?php
                      $query2 = "SELECT name FROM department where id='" . $_GET['xdpt'] . "'";
                      $dept = mysqli_query($conn, $query2);
                      $dept1 = mysqli_fetch_assoc($dept);
                      $dept_name = $dept1['name'];
                      ?>
                      <p style="margin: 0" style="font-size: 3px;">Department</p>
                      <input type="text" class="form-control" name="dptss" value="<?php echo $dept_name; ?>" readonly>
                      <input type="text" style="display:none" class="form-control" name="xxdpt" value="<?php echo $_GET['xdpt']; ?>" readonly>
                    </div>
                  </div>

                  <div class="row g-3">
                    <div class="col">
                      <p style="margin: 0" style="font-size: 3px;">Paygrade</p>
                      <input type="text" class="form-control" name="xxpaygrade" value="<?php echo $_GET['xpaygrade']; ?>" readonly>
                    </div>
                    <div class="col">
                      <p style="margin: 0" style="font-size: 3px;">Status</p>
                      <input type="text" class="form-control" name="xxstatus" value="<?php echo $_GET['xstatus']; ?>" readonly>
                    </div>
                  </div>
                  <div class="row g-3" style="margin-top: 0.5px;">
                    <div class="col">
                      <p style="margin: 0;color:red">Supervisor ID</p>
                      <input type="text" class="form-control" name="xxsid" placeholder="Supervisor ID" required>
                    </div>
                  </div>
                </div>

                <h5 style="margin-top: 10px" class="md-3">Account details</h5>
                <div class="md-3">
                  <div class="col">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxbnkname" value="<?php echo $_GET['xbnkname']; ?>" readonly>
                  </div>
                  <div class="col">
                    <input type="text" style="margin-top: 5px" class="form-control" name="xxbrnchname" value="<?php echo $_GET['xbrnchname']; ?>" readonly>
                  </div>
                </div>
                <input type="text" style="margin-top: 5px" class="form-control" name="xxaccn" value="<?php echo $_GET['xaccn']; ?>" readonly>
              </div>
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
                      $attr_namex='x'.$attr_name;
                      echo "<input style='margin-top: 10px' type='text' class='form-control' name='$attr_namexx' value='".$_GET[$attr_namex]."' required />"
                      ?>
                    <?php
                    }
                  }
                  ?>
                <div>
              <div class="row">
                <div class="col text-center">
                  <input style="margin: 10px" class="btn btn-primary " type="submit" value="Approve">
                </div>
              </div>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</body>

>>>>>>> Stashed changes:jupiter/admin_add_user.php
</html>