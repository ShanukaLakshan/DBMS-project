<?php
include('admin_config.php');
$conn = mysqli_connect($sname, $uname, $password, $db_name);

try {
    $pdo = new PDO(
        "mysql:host=" . "localhost" . ";dbname=" . $db_name . ";charset=" . "utf8",
        $uname,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (Exception $ex) {
    exit($ex->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <title>Add New User</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center " style="min-height: 100vh">
        <!-- <form method="POST" class="border shadow p-3 rounded"> -->
        <form method="post" enctype="multipart/form-data" class="border shadow p-3 rounded ">
            <h1 style="margin-bottom: 20px" class="md-5">Enter user details</h1>

            <h5 class="md-3">User details</h5>
            <div class="md-3">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" name="uname" placeholder="User name" />
                        <br>
                        <input type="text" class="form-control" name="id" placeholder="ID" />
                        <br>
                        <input type="password" class="form-control" name="pwd" placeholder="Password" />
                        <br>
                        <input type="text" class="form-control" name="utype" placeholder="User type" />
                        <br>
                        <input type="file" name="upload" accept=".png,.gif,.jpg,.webp" required />
                        <input type="submit" name="submit" value="Upload Image" />

                    </div>
                    <!-- <input class="btn btn-primary" type="submit" value="Add User" style="margin-top: 20px;" /> -->
        </form>
        <?php
        if (isset($_FILES["upload"])) {
            try {
                include('admin_config.php');
                $conn = mysqli_connect($sname, $uname, $password, $db_name);

                $user_name = $_POST['uname'];
                $id = $_POST['id'];
                $pwd = $_POST['pwd'];
                $user_type = $_POST['utype'];

                $stmt = $pdo->prepare("INSERT INTO `user` (`user_name`,`id`,`password`,`user_type`,`img_name`, `img_data`) VALUES ('$user_name','$id','$pwd','$user_type',?,?)");
                $stmt->execute([$_FILES["upload"]["name"], file_get_contents($_FILES["upload"]["tmp_name"])]);
                echo "Uploaded";
                try {
                    $pdo = new PDO(
                        "mysql:host=" . "localhost" . ";dbname=" . $db_name . ";charset=" . "utf8",
                        $uname,
                        $password,
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                        ]
                    );
                } catch (Exception $ex) {
                    exit($ex->getMessage());
                }
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
        }
        ?>
    </div>

</body>

</html>