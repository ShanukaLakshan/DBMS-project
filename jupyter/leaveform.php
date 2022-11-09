<?php
include 'user_config.php';
$conn = mysqli_connect($sname, $uname, $password, $db_name);


?>

<!DOCTYPE html>
<html>

<head>
    <title>Request leave</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
            <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
                <div>
                    <form method="POST" class="border shadow p-3 rounded" action="index.html">
                        <h5 class="md-3">Leave details</h5>
                        <div class="md-3">
                            <div class="row">
                                <div class="col">
                                    <p style="margin: 0" style="font-size: 3px">Name</p>
                                    <input type="text" style="margin-top: 1px" class="form-control" name="xuname" value="<?php echo $_GET['uname'] ?>" placeholder="<?php echo $_GET['id'] ?>" readonly />
                                </div>
                                <div class="col">
                                    <p style="margin: 0" style="font-size: 3px">ID</p>
                                    <input type="text" style="margin-top: 1px" class="form-control" name="xid" value="<?php echo $_GET['id'] ?>" placeholder="<?php echo $_GET['id'] ?>" readonly />
                                </div>
                            </div>
                            <p style="margin: 0" style="font-size: 3px">Date</p>
                            <input type="date" style="margin-top: 1px" class="form-control" name="xdate" />
                        </div>
                        <div>
                            <p style="margin: 0" style="font-size: 3px">
                                Select Leave Type
                            </p>
                            <select class="form-select" name="xleave_type">
                                <option>Leave Type</option>
                                <?php
                                $query = "show columns from leave_detail where Field not in ('pay_grade','job_title')";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $row['Field'] . "'>" . $row['Field'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary" value="Send"> send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>