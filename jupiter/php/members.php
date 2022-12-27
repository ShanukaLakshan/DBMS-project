<?php

if (isset($_SESSION['username']) && isset($_SESSION['userpassword'])) {

    $sql = "SELECT * FROM employee ORDER BY id ASC";
    $res = mysqli_query($conn, $sql);
} else {
    header("Location: index.php");
}
