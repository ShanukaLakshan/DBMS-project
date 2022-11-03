<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <title>Document</title>
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
    <form method="POST" class="border shadow p-3 rounded" action="http://localhost:8080/jupyter/add_user_database.php">
      <h1 style="margin-bottom: 20px" class="md-5">Filled
        <?php echo $_GET['xfname']; ?>'s details
      </h1>
      <h5 class="md-3">Personal details</h5>
      <div class="md-3">
        <div class="row">
          <div class="col">
            <p style="margin: 0" style="font-size: 3px;">First Name</p>
            <input type="text" style="margin-top: 1px" class="form-control" name="xxfname" value="<?php echo $_GET['xfname']; ?>" readonly>
          </div>
          <div class="col">
            <p style="margin: 0" style="font-size: 3px;">Last Name</p>
            <input type="text" style="margin-top: 1px" class="form-control" name="xxlname" value="<?php echo $_GET['xlname']; ?>" readonly>
          </div>
        </div>
        <p style="margin: 0" style="font-size: 3px;">Email</p>
        <input type="text" style="margin-top: 1px" class="form-control" name="xxemail" value="<?php echo $_GET['xemail']; ?>" readonly>
        <p style="margin: 0" style="font-size: 3px;">Birthday</p>
        <input type="date" style="margin-top: 1px" class="form-control" name="xxbdate" value="<?php echo $_GET['xbdate']; ?>" readonly>
      </div>
      <p style="margin: 0" style="font-size: 3px;">Gender</p>
      <input type="text" style="margin-top: 1px" class="form-control" name="xxgender" value="<?php echo $_GET['xgender']; ?>" readonly>
      <br>
      <label style="margin-top: 1px" class="col-sm-4 control-label">Address</label>
      <div class="row g-3">
        <div class="col-sm-5">
          <p style="margin: 0" style="font-size: 3px;">City</p>
          <input type="text" class="form-control" name="xxcity" value="<?php echo $_GET['xcity']; ?>" readonly>
        </div>
        <div class="col-sm-4">
          <p style="margin: 0" style="font-size: 3px;">Province</p>
          <input type="text" class="form-control" name="xxprovince" value="<?php echo $_GET['xprovince']; ?>" readonly>
        </div>
        <div class="col-sm">
          <p style="margin: 0" style="font-size: 3px;">Zip Code</p>
          <input type="text" class="form-control" name="xxzip" value="<?php echo $_GET['xzip']; ?>" readonly>
        </div>
      </div>

      <h5 style="margin-top: 10px" class="md-3">Employment details</h5>
      <div class="md-3">
        <div class="row">
          <div class="col">
            <div class="col">
              <p style="margin: 0" style="font-size: 3px;">Job Title</p>
              <input type="text" class="form-control" name="xxjtitle" value="<?php echo $_GET['xjtitle']; ?>" readonly>
            </div>
          </div>
          <div class="col">
            <p style="margin: 0" style="font-size: 3px;">Department</p>
            <input type="text" class="form-control" name="xxdpt" value="<?php echo $_GET['xdpt']; ?>" readonly>
          </div>
        </div>

        <div style="margin-top: 2px" class="row g-3">
          <div class="col">
            <p style="margin: 0" style="font-size: 3px;">Pay Grade</p>
            <input type="text" class="form-control" name="xxpaygrade" value="<?php echo $_GET['xpaygrade']; ?>" readonly>
          </div>
          <div class="col">
            <p style="margin: 0" style="font-size: 3px;">Status</p>
            <input type="text" class="form-control" name="xxstatus" value="<?php echo $_GET['xstatus']; ?>" readonly>
          </div>
        </div>
      </div>

      <h5 style="margin-top: 10px" class="md-3">Account details</h5>
      <div class="md-3">
        <div class="row">
          <div class="col">
            <p style="margin: 0" style="font-size: 3px;">Bank Name</p>
            <input type="text" class="form-control" name="xxbnkname" value="<?php echo $_GET['xbnkname']; ?>" readonly>
          </div>
          <div class="col">
            <p style="margin: 0" style="font-size: 3px;">Branch Name</p>
            <input type="text" class="form-control" name="xxbncname" value="<?php echo $_GET['xbncname']; ?>" readonly>
          </div>
        </div>
        <p style="margin: 0" style="font-size: 3px;">Account Name</p>
        <input type="text" class="form-control" name="xxaccn" value="<?php echo $_GET['xaccn']; ?>" readonly>
      </div>
      <br>
      <div class="border border-primary">
        <div style="margin:20px;width:90%;" class="h4 pb-2 mb-4 text-danger border-bottom border-danger container d-flex justify-content-center align-items-center">
          Admin Authentification</div>
        <div class="md-1">

          <div class="mb-3" style="margin:20px;width:90%;">
            <label class="form-label">User Name</label>
            <input name="uname" type="text" class="form-control" required>
          </div>
          <div class="mb-3" style="margin:20px;width:90%;">
            <label class="form-label">Password</label>
            <input name="pwd" type="password" class="form-control" required>
          </div>
          <div class="container d-flex justify-content-center align-items-center">
            <input style="margin: 10px" class="btn btn-primary " type="submit" value="Approve">
          </div>
        </div>
    </form>
  </div>
</body>

</html>