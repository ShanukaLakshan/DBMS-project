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
              <h1 style="margin-bottom: 20px;text-align: center; " class="md-5">Enter your details</h1>
            </div>
          </div>
          <form action="user_details_collector.php" method="POST">
            <div class="row ">
              <div class="col-md-6">

                <h5 class="md-3">Personal details</h5>
                <div class="md-3">
                  <div class="row">
                    <div class="col">
                      <input type="text" class="form-control" name="fname" placeholder="First name" required />
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" name="lname" placeholder="Last name" required />
                    </div>
                  </div>
                  <input type="mail" style="margin-top: 10px" name="email" placeholder="Email : saman@gmail.com" class="form-control" required />
                  <input type="text" style="margin-top: 10px" name="phone" placeholder="Phone : 0771234567" maxlength="10" minlength="10" class="form-control" required />
                  <input type="date" style="margin-top: 10px" name="bdate" class="form-control" required />
                </div>
                <div class="row">
                  <div class="col">
                    <label style="margin-top: 10px" class="col-sm-7 control-label">Select Gender</label>
                    <div class="col-sm-8">
                      <label class="radio-inline">
                        <input type="radio" name="gender" value="male" required /> Male
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="gender" value="female" required /> Female
                      </label>
                    </div>
                  </div>
                  <div class="col">
                    <select class="form-select" name="marital" style="margin-top:30px" required>
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
                    <input style="margin-top:10px; margin-bottom:10px" type="text" class="form-control" name="add1" placeholder="Address line 1" required />
                  </div>
                </div>
                <div class="row g-3">
                  <div class="col">
                    <input style="margin-bottom:10px" type="text" class="form-control" name="add2" placeholder="Address line 2" required />
                  </div>
                </div>
                <div class="row g-3">
                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="city" placeholder="City" required />
                  </div>
                  <div class="col-sm-4">
                    <select class="form-select" name="province" required>
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
                    <input type="text" class="form-control" name="zip" placeholder="Zip" required />
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
                        <select class="form-select" name="jtitle" required>
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
                      <select class="form-select" name="dpt" required>
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
                      <select class="form-select" name="paygrade" required>
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
                      <select class="form-select" name="status" required>
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
                      <input type="text" name="s_id" placeholder="Supervisor ID" class="form-control" style="display: none;" />
                    </div>
                  </div>
                </div>

                <h5 style="margin-top: 10px" class="md-3">Account details</h5>
                <div class="md-3">
                  <div class="row">
                    <div class="col">
                      <input type="text" class="form-control" name="bnkname" placeholder="Bank name" required />
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" name="brnchname" placeholder="Branch name" required />
                    </div>
                  </div>
                  <input type="text" style="margin-top: 10px" name="accn" placeholder="Account Number" class="form-control" required />
                </div>
                <div class="md-3">
                  <?php
                  $query = "SELECT * FROM custom_attribute";
                  $result = $conn->query($query);
                  if ($result->num_rows > 0) {
                    echo "<h5 style='margin-top: 10px' class='md-3'>Other Informations</h5>";
                    $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    foreach ($options as $option) {
                      $attr_id=$option['attr_id'];
                      $attr_name=$option['name'];
                      echo "<input style='margin-top: 10px' type='text' class='form-control' name='$attr_id' placeholder='$attr_name' required />"
                      ?>
                    <?php
                    }
                  }
                  ?>
                <div>

              </div>
            </div>
            <div class="row">
              <div class="col text-center">
                <input style="margin-top: 10px" class="btn btn-primary" type="submit" value="Send" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</body>

</html>