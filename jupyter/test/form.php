<?php
include_once('processForm.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Image Preview and Upload PHP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-4 offset-md-4 form-div">
                <a href="profiles.php">View all profiles</a>
                <form action="form.php" method="post" enctype="multipart/form-data">
                    <h2 class="text-center mb-3 mt-3">Update profile</h2>
                    <?php if (!empty($msg)) : ?>
                        <div class="alert <?php echo $msg_class ?>" role="alert">
                            <?php echo $msg; ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group text-center" style="position: relative;">
                        <span class="img-div">
                            <div class="text-center img-placeholder" onClick="triggerClick()">
                                <h4>Update image</h4>
                            </div>
                            <img src="./profile_image.png" onClick="triggerClick()" id="profileDisplay">
                        </span>
                        <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
                        <label>Profile Image</label>
                    </div>
                    <div class="form-group">
                        <label>Bio</label>
                        <textarea name="bio" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="save_profile" class="btn btn-primary btn-block">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<script src="script.js"></script>