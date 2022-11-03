<?php
$sname = "localhost";
$uname = "" . $_POST['uname'];
$password = "" . $_POST['pwd'];
$db_name = "jupyter";

try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
    $sql1 = mysqli_query($conn, "SELECT * FROM employee WHERE id = $uname ");
    $row = mysqli_fetch_array($sql1);
} catch (Exception $e) {
    echo "Connection Failed!";
    exit();
}
echo "Connection Successful!";

?>
<!DOCTYPE html>
<html>

<head>
    <title> Retrive data</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    </head>

<body>
    <div class="container d-flex justify-content-center align-items-center " style="min-height: 100vh">
        <form method="POST" class="border shadow p-3 rounded" action="add_user_success.html">
            <h1 style="margin-bottom: 20px" class="md-5">Filled
                <?php echo $row['name']; ?>'s details
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
            <button type="submit" class="btn btn-primary">Log out</button>

        </form>
    </div>

</body>

</html>