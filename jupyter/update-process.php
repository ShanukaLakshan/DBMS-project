<?php
include_once 'database.php';
if(count($_POST)>0) {
    mysqli_query($conn,"UPDATE users set name='" . $_POST['name'] . "', 
    uname='" . $_POST['uname'] . "' WHERE id='" . $_POST['id'] . "'");
    $message = "<p style='color:green;'>Record Modified Successfully !</p>";
}
    $result = mysqli_query($conn,"SELECT * FROM users WHERE id='" . $_GET['id'] . "'");
    $row= mysqli_fetch_array($result);
?>
<html>
    <head>
        <title>Update User Data</title>
    </head>
<body>
    <form name="frmUser" method="post" action="">
        <div>
            <?php if(isset($message)) { echo $message; } ?>
        </div>
        <div style="padding-bottom:5px;">
            <a href="retrieve.php">User List</a>
        </div>
        ID: <br>
        <input type="hidden" name="id" class="txtField" value="<?php echo $row['id']; ?>">
        Name: <br>
        <input type="text" name="name" class="txtField" value="<?php echo $row['name']; ?>">
        <br>
        User Name :<br>
        <input type="text" name="uname" class="txtField" value="<?php echo $row['uname']; ?>">
        <br>
        Role:<br>
        <input type="text" name="role" class="txtField" value="<?php echo $row['role']; ?>">
        <br>
        <input type="submit" name="submit" value="Submit" class="buttom">                               

    </form>
</body>
</html>