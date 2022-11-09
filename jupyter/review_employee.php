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
<html>

<head>
    <title> Retrive data</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="row align-items-center " style="min-height: 100vh">
            <form class="border shadow p-3 rounded">

                <?php
                if ($row2['user_type'] == 'admin') { ?>
                    <!-- For Admin -->
                    <div class="p-2">
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM employee");
                        if (mysqli_num_rows($result) > 0) { ?>

                            <h1 class="display-4 fs-1">Employees</h1>
                            <table class="table" style="width: auto;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <td>Name</td>
                                        <td>ID</td>
                                        <td>Gender</td>
                                        <td>Phone Number</td>
                                        <td>Email</td>
                                        <td>Birth Date</td>
                                        <td>Marital Status</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <th scope="row"><?= $i ?></th>
                                            <td><?php echo $row["name"]; ?></td>
                                            <td><?php echo $row["id"]; ?></td>
                                            <td><?php echo $row["gender"]; ?></td>
                                            <td><?php echo $row["phone_number"]; ?></td>
                                            <td><?php echo $row["email"]; ?></td>
                                            <td><?php echo $row["birth_date"]; ?></td>
                                            <td><?php echo $row["marital_status"]; ?></td>
                                            <td><a href="update-process.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary sm-4">Update</a></td>
                                        </tr>
                                    <?php $i++;
                                    } ?>
                                </tbody>
                            </table>

                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <p style="display: none;"></p>
                <?php } ?>
            </form>


        </div>
    </div>
</body>

</html>