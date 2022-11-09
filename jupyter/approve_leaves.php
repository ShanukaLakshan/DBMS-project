<?php
include('user_config.php');
include('admin_config.php');
try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
} catch (Exception $e) {
    echo "<p style='color:red;'>Database Connection Failed !</p>";
    exit();
}

try {
    $us_name = $_GET['get_username'];
    $get_leaves = "select * FROM leave_request WHERE id in (SELECT id FROM supervisor where supervisor_id = '" . $us_name . "') and status='pending'";
    $leaves = mysqli_query($conn, $get_leaves);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <title>Approve Leaves</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
        <div class="border shadow p-3 rounded">
            <div class="p-2">
                <?php
                if (mysqli_num_rows($leaves) > 0) { ?>

                    <h1 class="display-4 fs-1">Leaves</h1>
                    <table class="table" style="width: auto;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <td>ID</td>
                                <td>Type</td>
                                <td>Date</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($leaves)) { ?>
                                <tr>
                                    <th scope="row"><?= $i ?></th>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["type"]; ?></td>
                                    <td><?php echo $row["date"]; ?></td>
                                    <td><?php echo $row["status"]; ?></td>
                                    <form action="approved.php" method="GET">
                                        <input type="text" name="get_username" value="<?php echo $us_name ?>" style="display: none;" />
                                        <input type="text" name="date" value="<?php echo $row["date"]; ?>" style="display: none;" />
                                        <input type="text" name="id" value="<?php echo $row["id"]; ?>" style="display: none;" />
                                        <td><button type="submit" class="btn btn-success">Approve</a></td>
                                    </form>
                                    <td><a href="" class="btn btn-danger">Decline</a></td>
                                </tr>
                            <?php $i++;
                            } ?>
                        </tbody>
                    </table>

                <?php } ?>
            </div>
        </div>
    </div>

</body>

</html>