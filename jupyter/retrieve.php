<?php
include_once 'database.php';
$result = mysqli_query($conn, "SELECT * FROM users");
?>
<!DOCTYPE html>
<html>

<head>
    <title> Retrive data</title>
</head>

<body>
    <?php
    if (mysqli_num_rows($result) > 0) {
    ?>
        <table>
            <tr>
                <td>Sl No</td>
                <td>Name</td>
                <td>User name</td>
                <td>Role</td>
                <td>Action</td>

            </tr>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["uname"]; ?></td>
                    <td><?php echo $row["role"]; ?></td>
                    <td><a href="update-process.php?id=<?php echo $row["id"]; ?>">Update</a></td>
                </tr>
            <?php
                $i++;
            }
            ?>
        </table>

    <?php } else {
        echo "No result found";
    }
    ?>

</body>

</html>