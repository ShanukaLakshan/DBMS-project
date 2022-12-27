<?php
include('user_config.php');
include('db_connector.php');

try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
} catch (Exception $e) {
    echo "<p style='color:red;'>Database Connection Failed !</p>";
    exit();
}
if(isset($_COOKIE['id'])){
    $id=$_COOKIE['id'];
}
else{
    if(isset($_POST['id'])){
        $id=$_POST['id'];
        setcookie("id",$id,time()+3600);
    }
    else{
        header("location:new_user.php?ierr=1");
        exit();
    }
}

$user_id=$conn->prepare("SELECT * FROM user WHERE id=?");
$emp_id=$conn->prepare("SELECT * FROM employee WHERE id=?");    
$user_id->bind_param("i", $id);
$user_id->execute();
$result = $user_id->get_result();
$emp_id->bind_param("i",$id);
$emp_id->execute();
$result2 = $emp_id->get_result();
// $row=mysqli_query($conn,"SELECT * FROM user WHERE id=".$_POST['id']."");
// $row2=mysqli_query($conn,"SELECT * FROM employee WHERE id=".$_POST['id']."");
if((mysqli_num_rows($result)>0) || (mysqli_num_rows($result2)==0)){
    setcookie("id","",time()-1);
    header("location:new_user.php?err=1");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jupiter - Register User</title>
    <link rel="icon" type="image/x-icon" href="./img/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
      background-image: url(./img/rbackground.jpg);
      background-size: 100%;
      background-position: 10%;
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
            border-color: #6f1d1b;
        }
        .btn-outline-warning:hover {
            color: #ffffff !important;
            background-color: #6f1d1b;
            border-color: #6f1d1b;
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
  width: 100%;
  color: white;
  height: 100%;
  background: black;
  opacity: .7;
  height: 200px;
  border-radius: 50%;
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
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center align-content-center" style="min-height:100vh">
            <div class="col-auto">
                <div class="card" style="width: 50rem; background-color: #ffffff68;">
                    <div class="card-header text-center">
                        <h3 class="card-title">Register User </h3>
                        <h4>Employee ID :<?php echo $id; ?></h4>
                    </div>
                    <div class="card-body">
                        <form action="user_reg.php" method="POST" enctype="multipart/form-data">
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <div class="row m-2">
                                        <div class="col-auto">
                                            <label>Username</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="id" value="<?php echo $id; ?>" style="display: none"/>
                                                <input type="text" class="form-control" name="uname" placeholder="Username"
                                                    aria-label="Username" required/>
                                            </div>
                                        </div>
                        
                                    </div>
                                    <div class="row m-2">
                                        <div class="col-auto">
                                        <label>Password</label>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="pass-1" placeholder="Password"
                                                    aria-label="Change Password" required/>
                                            </div>
                                        </div>
                                        </div>
                                    <div class="row m-2">
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="pass-2" placeholder="Confirm Password"
                                                aria-label="Confirm Password" required/>
                                            <p style="color:#ff0000;margin-top: 2%;">
                                                <?php
                                            if(isset($_REQUEST["pass"]))
                                                echo "Passwords do not match";
                                            ?>
                                            </p>
                                            <p style="color:#ff0000;margin-top: 2%;">
                                                <?php
                                        if(isset($_REQUEST["passl"]))
                                            echo "Passwords is too short";
                                        ?>
                                            </p>
                                            <p style="color:#ff0000;margin-top: 2%;">
                                                <?php
                                            if(isset($_REQUEST["user"]))
                                                echo "Username is already taken";
                                            ?>
                                            </p>
                                            <p style="color:#ff0000;margin-top: 2%;">
                                                <?php
                                            if(isset($_REQUEST["error"]))
                                                echo "Incorrect Password!";
                                            ?>
                                            </p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-auto">
                                    <div class="form-group text-center" style="position: relative;" >
                                        <span class="img-div">
                                          <div class="text-center img-placeholder"  onClick="triggerClick()">
                                            <h4>Update image</h4>
                                          </div>
                                          <img src="img/user-default.png" onClick="triggerClick()" id="profileDisplay" style="border-radius: 100%;width:200px;height:auto;">
                                        </span>
                                        <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">                                      </div>
                                </div>
                            </div>
                            <div class="row justify-content-center" style="margin-top:5%">
                                <div class="col-auto">
                                    <div class="form-group">
                                        <button type="submit" name="save_profile" class="btn btn-primary btn-block" style="margin-bottom:5%">Save Changes</button>
                                    </div>
                        </form>
                                </div>
                                <div class="col-auto">
                                    <form action="back_add_user.php">
                                        <button type="submit" class="btn btn-outline-warning">Back</button>
                                    </form>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="script.js"></script>

</html>