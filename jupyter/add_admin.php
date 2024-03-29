<?php

include('user_config.php');
include('db_connector.php');

try {
    $conn = mysqli_connect($sname, $uname, $password, $db_name);
} catch (Exception $e) {
    echo "<p style='color:red;'>Database Connection Failed !</p>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Add new admin</title>
    <link rel="icon" type="image/x-icon" href="./img/favicon.png" />
</head>
<style>
    body {
        background-color: #635666;
    }

    /* The side navigation menu */
    .sidebar {
        margin: 0;
        padding: 0;
        width: 100px;
        background-color: #ECE5C7;
        position: fixed;
        height: 100%;
        overflow: auto;
        text-align: center;
        justify-content: center;
        border-color: #354259;
    }

    /* Sidebar links */
    .sidebar a {
        display: flex;
        color: black;
        padding: 10px 12px;
        text-decoration: none;
        height: 82px;
        text-align: center;
        justify-content: center;

    }

    /* Active/current link */
    .sidebar a.active {
        background-color: #354259;
        color: rgb(255, 255, 255);
    }

    /* Links on mouse-over */
    .sidebar a:hover:not(.active) {
        background-color: #555;
        color: white;
    }

    /* Page content. The value of the margin-left property should match the value of the sidebar's width property */
    div.content {
        margin-left: 90px;
        padding: 1px 16px;
        height: auto;
    }

    .container-fluid {
        margin-right: 100px;
        max-width: 1900px;
    }

    /* On screens that are less than 700px wide, make the sidebar into a topbar */
    @media screen and (max-width: 700px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        .sidebar a {
            float: right;
        }

        div.content {
            margin-left: 0;
        }
    }

    /* On screens that are less than 400px, display the bar vertically, instead of horizontally */
    @media screen and (max-width: 400px) {
        .sidebar a {
            text-align: end;
            float: none;
        }
    }

    /* Dropdown Button */
    .dropbtn {
        background-color: #3e8e4100;
        color: black;
        padding: 0px;
        width: fit-content;
        max-height: 30px;
        font-size: 16px;
        align-self: flex-end;
        border: none;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f186;
        min-width: 145px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0);
        z-index: 1;
        left: 0;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: rgb(221, 221, 221);
    }

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {
        background-color: #3e8e4100;
    }

    .progress-bar-warning {
        background-color: #635666;

    }

    .btn-sq {
        border-radius: 0px;
        background-color: #CDC2AE;
        height: 82px !important;
        width: 100px !important;
    }

    .btn:hover {
        background-color: #354259;
        border-radius: 0px;
        color: white
    }

    .btn-primary {
        background-color: #635666;
        color: white;
        border-color: #635666;
    }

    .btn-primary:hover {
        background-color: #8d7992;
        border-radius: 10%;
        border-color: #8d7992;
        color: white
    }

    /* Style the sidenav links and the dropdown button */
    .sidenav a,
    .dropdown-btn {
        padding: 6px 8px 6px 16px;
        text-decoration: none;
        font-size: 16px;
        color: #000000;
        display: block;
        border: none;
        background: none;
        width: 100%;
        height: 10%;
        text-align: center;
        cursor: pointer;
        outline: none;
    }

    /* On mouse-over */
    .sidenav a:hover,
    .dropdown-btn:hover {
        background-color: #555;
        color: white;
    }

    /* Main content */


    /* Add an active class to the active dropdown button */
    .active {
        background-color: #354259;
        color: rgb(255, 255, 255);
    }

    /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
    .dropdown-container {
        display: none;
        background-color: #fff4c1;
    }

    /* Optional: Style the caret down icon */
    .fa-caret-down {
        float: center;
        padding-right: 8px;
    }
</style>

<body>

    <div class="sidebar">
        <a href="./homepage.php" class="text-center">
            <p class="text-center"><i class="fa fa-home fa-2x" aria-hidden="true"></i><br>Home</p>
        </a>
    </div>
    <div class="content">
        <div class="row col-lg-15 " style="background-color:#354259;">
            <div class="col">
                <a href='./homepage.php'>
                    <img class="border-dark " src="./img/jupiter_logo.png" style="width:250px;margin-bottom: 5px;margin-left: 10px;">
                </a>
            </div>
            <div class="col-lg-3 align-self-center text-center">
                <h4 style="color:rgb(255, 255, 255)">Add New Jupiter Admin</h4>
            </div>

        </div>
        <div class="container-fluid mx-1">
            <div class="row h-100 w-100 justify-content-center">
                <div class="card h-100 " style="background-color: #ffffff74;">
                    <div class="row justify-content-center">
                        <div class="col">
                            <div class="card  rounded-3  " style=" background-color: #ffffff;margin:2% ">
                                <div class="card-header mb-3" style="background-color:#ECE5C7 " ;>
                                    <h2 style="text-align: center; " class="md-5 mt-2">Enter Admin details</h2>
                                </div>
                                <div class="card-body" style="padding:2%">
                                    <form action="add_admin_database.php" method="POST">
                                        <div class="row ">
                                            <div class="col-md-6">

                                                <h5 class="md-3">Personal details</h5>
                                                <div class="md-3">
                                                    <div class="row">
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="xxfname" placeholder="First name" required />
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="xxlname" placeholder="Last name" required />
                                                        </div>
                                                    </div>
                                                    <input type="mail" style="margin-top: 10px" name="xxemail" placeholder="Email : saman@gmail.com" class="form-control" required />
                                                    <input type="text" style="margin-top: 10px" name="xxphone" placeholder="Phone : 0771234567" maxlength="10" minlength="10" class="form-control" required />
                                                    <input type="date" style="margin-top: 10px" name="xxbdate" class="form-control" max="<?php echo date("Y-m-d");?>" required />
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label style="margin-top: 10px" class="col-sm-7 control-label">Select Gender</label>
                                                        <div class="col-sm-8">
                                                            <label class="radio-inline">
                                                                <input type="radio" name="xxgender" value="male" required /> Male
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="xxgender" value="female" required /> Female
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <select class="form-select" name="xxmarital" style="margin-top:30px" required>
                                                            <option value="">Marital Status</option>
                                                            <option value="single">Single</option>
                                                            <option value="married">Married</option>
                                                            <option value="divorced">Divorced</option>
                                                            <option value="widowed">Widowed</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <label style="margin-top: 10px" class="col-sm-4 control-label">Address</label>
                                                <div class="row g-3">
                                                    <div class="col">
                                                        <input style="margin-top:10px; margin-bottom:10px" type="text" class="form-control" name="xxadd1" placeholder="Address line 1" required />
                                                    </div>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col">
                                                        <input style="margin-bottom:10px" type="text" class="form-control" name="xxadd2" placeholder="Address line 2" required />
                                                    </div>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control" name="xxcity" placeholder="City" required />
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <select class="form-select" name="xxprovince" required>
                                                            <option value="">Province</option>
                                                            <option value="Central">Central</option>
                                                            <option value="North Central">North Central</option>
                                                            <option value="Northern">Northern</option>
                                                            <option value="Eastern">Eastern</option>
                                                            <option value="North Western">North Western</option>
                                                            <option value="Southern">Southern</option>
                                                            <option value="Uva">Uva</option>
                                                            <option value="Southern">Southern</option>
                                                            <option value="Western">Western</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm">
                                                        <input type="text" class="form-control" name="xxzip" placeholder="Zip" required />
                                                    </div>
                                                </div>

                                                <br />

                                            </div>
                                            <div class="col-md-6">
                                                <h5 style="margin-top: 10px" class="md-3">Employment details</h5>
                                                <div class="md-3">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="col">
                                                                <select class="form-select" name="xxjtitle" required>
                                                                    <option value="">Job Title</option>
                                                                    <?php
                                                                    $query = "SELECT DISTINCT * FROM job ORDER BY job_title";
                                                                    $result = $conn->query($query);
                                                                    if ($result->num_rows > 0) {
                                                                        $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                                                    }
                                                                    foreach ($options as $option) {
                                                                    ?>
                                                                        <option value="<?php echo $option['job_id']; ?>"><?php echo $option['job_title']; ?> </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <select class="form-select" name="xxdpt" required>
                                                                <option value="">Department</option>
                                                                <?php
                                                                $query = "SELECT DISTINCT name FROM department ORDER BY name ASC";
                                                                $result = $conn->query($query);
                                                                if ($result->num_rows > 0) {
                                                                    $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                                                }
                                                                foreach ($options as $option) {
                                                                ?>
                                                                    <?php
                                                                    $query2 = "SELECT DISTINCT id FROM department where name='" . $option['name'] . "'";
                                                                    $dept = mysqli_query($conn, $query2);
                                                                    $dept1 = mysqli_fetch_assoc($dept);
                                                                    $dept_id = $dept1['id'];
                                                                    ?>
                                                                    <option value="<?php echo $dept_id; ?>"><?php echo $option['name']; ?> </option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div style="margin-top: 2px" class="row g-3">
                                                        <div class="col">
                                                            <select class="form-select" name="xxpaygrade" required>
                                                                <option value="">Pay Grade</option>
                                                                <?php
                                                                $query = "SELECT DISTINCT * FROM pay_level ORDER BY pay_grade ASC";
                                                                $result = $conn->query($query);
                                                                if ($result->num_rows > 0) {
                                                                    $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                                                }
                                                                foreach ($options as $option) {
                                                                ?>
                                                                    <option value="<?php echo $option['pay_grade']; ?>"><?php echo $option['title']; ?> </option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <select class="form-select" name="xxstatus" required>
                                                                <option value="">Status</option>
                                                                <?php
                                                                $query = "SELECT * FROM emp_status ORDER BY stat_id ASC";
                                                                $result = $conn->query($query);
                                                                if ($result->num_rows > 0) {
                                                                    $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                                                }
                                                                foreach ($options as $option) {
                                                                ?>
                                                                    <option value="<?php echo $option['stat_id']; ?>"><?php echo $option['title']; ?> </option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <h5 style="margin-top: 10px" class="md-3">Account details</h5>
                                                <div class="md-3">
                                                    <div class="row">
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="xxbnkname" placeholder="Bank name" required />
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="xxbrnchname" placeholder="Branch name" required />
                                                        </div>
                                                    </div>
                                                    <input type="text" style="margin-top: 10px" name="xxaccn" placeholder="Account Number" class="form-control" required />
                                                </div>
                                                <div class="md-3">
                                                    <?php
                                                    $query = "SELECT * FROM custom_attribute";
                                                    $result = $conn->query($query);
                                                    if ($result->num_rows > 0) {
                                                        echo "<h5 style='margin-top: 10px' class='md-3'>Other Informations</h5>";
                                                        $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                                        foreach ($options as $option) {
                                                        $attr_name=$option['name'];
                                                        echo "<input style='margin-top: 10px' type='text' class='form-control' name='$attr_name' placeholder='$attr_name' required />"
                                                        ?>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                    <div>

                                            </div>
                                                </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-center">
                                                <input class="btn btn-primary" type="submit" value="ADD NEW ADMIN" />
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>


            </div>



</body>
<script>
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
    // $(function() {
    //     var dtToday = new Date();
    //     var month = dtToday.getMonth() + 1;
    //     var dat = dtToday.getDate();
    //     var year = dtToday.getFullYear();
    //     if (month < 0)
    //         month = '0' + month.toString();
    //     if (date < 10)
    //         day = '0' + day.toString();
    //     var maxDate = year + '-' + month + '-' + day;
    //     $('.form-control').attr('max', maxDate);
    // });

    // $(document).ready(function() {
    //     $('#getdate').form - control({
    //         format: 'yyy-mm-dd',
    //         maxDate: new Date()
    //     })
    // })
</script>

</html>