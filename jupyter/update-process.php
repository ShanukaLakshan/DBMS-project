<?php
// get admin configurations ( because admin can update user details)
include_once 'admin_config.php';
$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (count($_POST) > 0) {
    mysqli_query($conn, "UPDATE employee set name='" . $_POST['name'] . "',email='" . $_POST['email'] . "', 
    gender='" . $_POST['gender'] . "' WHERE id='" . $_POST['id'] . "'");
    $message = "<p style='color:green;'>Record Modified Successfully !</p>";
}
$result = mysqli_query($conn, "SELECT * FROM employee WHERE id='" . $_GET['id'] . "'");
$row = mysqli_fetch_array($result);
?>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <title>Update User Data</title>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
            <div class="container d-flex justify-content-center align-items-center " style="min-height: 100vh">
                <form name="frmUser" method="POST" class="border shadow p-3 rounded" action="">
                    <div>
                        <?php if (isset($message)) {
                            echo $message;
                        } ?>
                    </div>
                    <h1 style="margin-bottom: 20px" class="md-5">
                        <?php echo $row['name']; ?>
                    </h1>
                    <h5 class="md-3">Update Personal details</h5>
                    <div class="md-3">
                        <div class="row">
                            <div class="col">
                                <p style="margin: 0" style="font-size: 3px;">ID</p>
                                <input type="text" style="margin-top: 1px" class="form-control" name="id" value="<?php echo $row['id']; ?> " readonly>
                            </div>
                            <div class="col">
                                <p style="margin: 0" style="font-size: 3px;">Name</p>
                                <input type="text" style="margin-top: 1px" class="form-control" name="name" value="<?php echo $row['name']; ?>">
                            </div>
                        </div>
                        <p style="margin: 0" style="font-size: 3px;">Email</p>
                        <input type="text" style="margin-top: 1px" class="form-control" name="email" value="<?php echo $row['email']; ?>">
                    </div>
                    <p style="margin: 0" style="font-size: 3px;">Gender</p>
                    <input type="text" style="margin-top: 1px" class="form-control" name="gender" value="<?php echo $row['gender']; ?>">
                    <br>
                    <button type="submit" name="submit" value="Submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
</body>

</html>