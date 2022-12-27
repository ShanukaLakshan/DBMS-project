
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Attributes</title>
</head>
<body>
    <div>
        <form action="add_custom.php" method="post">
            <label for="name">Attribute name</label>
            <input type="text" name="name" id="uname" required>
            <?php
            if(isset($_REQUEST['d'])){
                echo "<p style='color:red'> Successfully added </p>";
            }
            ?>
            <input type="submit">
    </div>
</body>
</html>