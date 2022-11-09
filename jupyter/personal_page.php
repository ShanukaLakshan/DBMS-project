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

// add image with user name
if (isset($_FILES["upload"])) {
    try {
        $us_name = $_POST['uname'];
        $stmt = $pdo->prepare("INSERT INTO `images` (`user_name`,`img_name`, `img_data`) VALUES ('$us_name',?,?)");
        $stmt->execute([$_FILES["upload"]["name"], file_get_contents($_FILES["upload"]["tmp_name"])]);
        echo "Image Uploaded";
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title> Retrive data</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
            <!-- FORE USERS -->
            <div class="container d-flex justify-content-center align-items-center " style="min-height: 100vh">
                <div>
                    <form method="POST" class="border shadow p-3 rounded" action="index.html">
                        <h1 style="margin-bottom: 20px" class="md-5">
                            <?php echo $row['name']; ?>
                        </h1>
                        <h5 class="md-3">Personal details</h5>
                        <div class="md-3">
                            <div class="row">
                                <div class="col">
                                    <p style="margin: 0" style="font-size: 3px;">ID</p>
                                    <input type="text" style="margin-top: 1px" class="form-control" name="xxfname" value="<?php echo $row['id']; ?>" readonly>
                                </div>
                                <div class="col">
                                    <p style="margin: 0" style="font-size: 3px;">Name</p>
                                    <input type="text" style="margin-top: 1px" class="form-control" name="xxlname" value="<?php echo $row['name']; ?>" readonly>
                                </div>
                            </div>
                            <p style="margin: 0" style="font-size: 3px;">Email</p>
                            <input type="text" style="margin-top: 1px" class="form-control" name="xxemail" value="<?php echo $row['email']; ?>" readonly>
                        </div>
                        <p style="margin: 0" style="font-size: 3px;">Gender</p>
                        <input type="text" style="margin-top: 1px" class="form-control" name="xxgender" value="<?php echo $row['gender']; ?>" readonly>
                        <br>
                    </form>
                    <div class="row btn-sm">
                        <form action="user_homepage.php" method="POST">
                            <input type="text" name="uname" value="<?php echo $username ?>" style="display: none;" />
                            <input type="password" name="pwd" value="<?php echo $userpassword ?>" style="display: none;" />
                            <button type="submit" class="btn btn-primary">
                                << Back</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>