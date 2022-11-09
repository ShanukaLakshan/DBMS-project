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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css" />
    <title>Jupiter - name</title>
    <link rel="icon" type="image/x-icon" href="./img/favicon.png">
    <style>
        body {
            background-image: url(./img/rbackground.jpg);
            background-size: 100%;
            background-position: 10%;
        }
    </style>
</head>

<body>
    <div class="row justify-content-md-center align-items-center" style="min-height:100vh">
        <div class="col col-lg-5">
            <div class="card border-primary shadow-lg" style="width:25 rem;background-color: #ffffff68; ">
                <h5 class="card-header text-center" style="background-color:#ffffffb7">Welcome, <?php echo $row['name'] ?></h5>
                <div class="card-body">
                    <div class="row ">
                        <div class="col">
                            <div class="text-center">
                                <form method="post" enctype="multipart/form-data">
                                    <div>
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
                                        echo "<img class='border border-primary rounded-circle' src='data:image/" . $ext . ";base64," . $img . "' alt='user image' style='width: 200px; height: 200px;'/>";
                                        ?>
                                    </div>
                                </form>
                            </div>

                            <h5 class="card-title fw-bold" style="margin-top: 10px;"><?php echo $row['name'] ?></h5>
                            <h6 class="card-title" style="margin-top: -5px;"><?php echo $row2['user_name'] ?></h6>
                        </div>
                        <div class="col align-items-center">
                            <div class="row btn-sm" style="margin-top:90px">
                                <form action="personal_page.php" method="POST">
                                    <input type="text" name="uname" value="<?php echo $username ?>" style="display: none;" />
                                    <input type="password" name="pwd" value="<?php echo $userpassword ?>" style="display: none;" />
                                    <button type="submit" class="btn btn-secondary">Personal Details</button>
                                </form>
                            </div>
                            <div class="text-end" style="margin-top:75px">
                                <a href="index.html" class="btn btn-danger">Logout</a>
                            </div>
                        </div>
                    </div>
                    <p class="card-text" style="margin-top:30px"></p>
                    <div class="row justify-content-center text-center">
                        <div class="col">
                            <form action="approve_leaves.php" method="GET">
                                <button type="submit" class="btn btn-primary position-relative" name="get_username" value="<?php echo $username; ?>">
                                    Pending approves
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"> <?php echo "" . mysqli_num_rows($leaves); ?>

                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </button>
                            </form>
                        </div>
                        <div class="col">
                            <form action="leaveform.php" action="GET">
                                <input type="text" name="uname" value="<?php echo $row['name'] ?>" style="display: none;">
                                <input type="text" name="id" value="<?php echo $row['id'] ?>" style="display: none;">
                                <button type="submit" class="btn btn-primary">Request a leave</button>
                            </form>
                        </div>
                        <?php if ($row2['user_type'] === 'admin') { ?>
                            <div class="col">
                                <form action="review_employee.php" method="POST">
                                    <input type="text" name="uname" value="<?php echo $username ?>" style="display: none;" />
                                    <input type="password" name="pwd" value="<?php echo $userpassword ?>" style="display: none;" />
                                    <button type="submit" class="btn btn-secondary">Review Employees</button>
                                </form>
                            </div>
                        <?php } else { ?>
                            <a href="#" class="btn btn-dark" style="display: none;">Review Employees</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>