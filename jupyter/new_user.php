<?php
if(isset($_COOKIE['id'])){
  header("location:add_user.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jupiter - New User</title>
    <link rel="icon" type="image/x-icon" href="./img/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
      background-image: url(./img/rbackground.jpg);
      background-size: 100%;
      background-position: 10%;
      }
      .btn-primary {
        color: white;
        background-color: rgba(210, 147, 94);
        border-color: rgba(210, 147, 94, 0.7);
      }

      .btn-primary:hover {
        color: white;
        background-color: rgb(169, 118, 77);
        border-color: rgb(169, 118, 77);
      }

      .btn-primary:active {
        color: #212529;
        background-color: rgb(204, 119, 149);
        border-color: #c25b76;
      }

      .btn-primary:disabled {
        color: #212529;
        background-color: #c3e6cb !important;
        border-color: #c3e6cb;
      }

      .btn-primary:focus {
        box-shadow: 0 0 0 0.2rem rgb(169, 118, 77);
        background-color: rgb(236, 162, 102) !important;
        border-color: rgb(236, 162, 102) !important;
        box-shadow: #723d00 !important;
        outline: #c25b76 !important;
      }
      .btn-outline-warning {
          color: #212529 !important;
          border-color: #6f1d1b;
        }
        .btn-outline-warning:hover {
          color: #ffffff !important;
          background-color: #6f1d1b;
          border-color: #6f1d1b;
      }
      .form-control {
        background-color: rgba(255, 255, 255, 0.5);
      }

      .form-control:focus {
        box-shadow: 0 0 0 0.2rem #6f1c1b70;
      }

      .form-select {
        background-color: rgba(255, 255, 255, 0.5);
      }

      .form-select:focus {
        box-shadow: 0 0 0 0.2rem #6f1c1b70;
      }

      .btn-danger {
        background-color: #9e2725 !important;
        border-color: #9e2725 !important;

      }

    </style>

</head>
<body>
    <div class="container-fluid" >
        <div class="row align-content-center justify-content-center" style="min-height:100vh ;">
            <div class="col-auto">

                <div class="card" style="width: 50rem; background-color: #ffffff68; ">
                    <div class="card-header">
                        <h3 class="text-center mt-2"> New User Registeration</h3>
                    </div>
                    <div class="card-body">
                                    <?php
                                    if(isset($_GET['err'])){
                                        echo "<p class='text-center' style='color:red'>Incorrect ID</p>";
                                    }
                                    if(isset($_GET['ierr1'])){
                                        echo "<p class='text-center' style=' color:red'>Enter Employee ID</p>";
                                    }
                                    ?>
                        <div class="row justify-content-center align-content-center mb-4">
                            <div class="col-auto">
                                <form action="add_user.php" method="POST">
                                    <input type="text" class="form-control" name="id" placeholder="Employee ID" required />
                                
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary " >GO</button>
                            </div>
                          </form>
                        </div>
                        <div class="row align-content-center justify-content-center">
                            <div class="col-auto ">
                                <p class="mt-2">Don't have an ID?</p>
                            </div>
                            <div class="col-auto">
                                <form action="register.php">
                                    <button type="submit" class="btn btn-outline-warning mt-1">Register Here</button>
                                </form>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                        <div class="col-auto">
                                    <form action="index.php">
                                        <button type="submit" class="btn btn-secondary mt-3">Back</button>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>