<?php 
if(isset($_REQUEST["err"]))
	$msg="Invalid username or Password";
?>
<p style="color:red;">
<?php
if(isset($_COOKIE['uname']))
  header("location:homepage.php");
?>

</p>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="style.css" />
    <title>Jupiter - Login</title>
    <link rel="icon" type="image/x-icon" href="./img/favicon.png" />
    <style>
      body {
        background-image: url(./img/lol1.jpg);
        background-size: 100%;
        background-position: top;
        background-repeat: no-repeat;
        background-attachment: fixed;
      }
      .ca {
        font-size: 14px;
        display: inline-block;
        padding: 10px;
        text-decoration: none;
        color: #444;
      }
      .ca:hover {
        text-decoration: underline;
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
      .border-primary {
        border-color: #6f1d1b !important;
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
      .btn-danger:hover {
        color: #ffffff !important;
        background-color: #6f1d1b !important;
        border-color: #6f1d1b !important;
      }
    </style>
  </head>
  <body>
    <div class="d-flex align-items-center position-static">
      <div class="row no-gutters h-100 fixed-top">
        <div class="row d-flex align-items-center">
          <div class="col-sm-6 text-center">
            <div
              class="card border-primary p-md-5 mx-md-4 rounded-3 shadow-lg"
              style="background-color: rgba(255, 255, 255, 0.4)"
            >
              <div class="container align-items-center">
                <div class="row">
                  <div
                    class="col-sm rounded-3 text-center"
                    style="background-color: rgb(255, 255, 255); padding: 0%"
                  >
                    <div class="text-black">
                      <div
                        class="card-header d-block img-fluid"
                        style="
                          background-image: url(./img/background4.jpg);
                          background-size: 150%;
                        "
                      >
                        <p
                          class="fw-bold"
                          style="color: #432818; font-size: 45px"
                        >
                          WE DRESS THE WORLD
                        </p>
                      </div>
                      <p class="small mb-0" style="padding: 2%">
                        Renowned for sustainable and ethical production of
                        apparels for brands around the world, our apparel &
                        textile industry is also a leading employment and
                        empowerment source for Sri Lankan women
                      </p>
                    </div>
                  </div>
                </div>
                <div class="w-100"><p></p></div>
                <div class="row">
                  <div class="col-sm">
                    <div class="card" style="width: 15rem">
                      <img
                        class="card-img-top"
                        src="./img/clothes1.jpg"
                        alt="Card image cap"
                        style="height: 135px"
                      />
                      <div class="card-body">
                        <p class="card-text">Finest materials</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="card" style="width: 15rem">
                      <img
                        class="card-img-top"
                        src="./img/staff1.jpg"
                        alt="Card image cap"
                      />
                      <div class="card-body">
                        <p class="card-text">Professional Staff</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 offset-1">
            <div
              class="card-body p-md-5 mx-md-4 rounded-3 shadow-lg"
              style="background-color: rgba(250, 214, 165, 0.4); margin: 20px"
            >
              <div class="text-center d-block img-fluid">
                <img
                  src="./img/jupiter_logo.png"
                  style="width: 280px"
                  alt="logo"
                />
                <h4 class="mt-sm pb-1">
                  <p
                    style="
                      font-family: Cambria, Cochin, Georgia, Times,
                        'Times New Roman', serif;
                      color: #5a3508;
                    "
                  >
                    Fashoion Fades, Style Lives!
                  </p>
                </h4>
              </div>

              <form
                action="login.php"
                method="post"
                class="text-center"
              >
                <p class="fw-bold fs-5" style="color: #432818">LOGIN ACCOUNT</p>

                <div class="form-outline mb-4">
                  <input
                    type="text"
                    name="uname"
                    class="form-control"
                    placeholder="Enter User Name"
                    required
                  />
                </div>

                <div class="form-outline mb-4">
                  <input
                    type="password"
                    name="pwd"
                    placeholder="Enter Password"
                    class="form-control"
                    required
                  />
                </div>

                <div class="text-center pt-1 mb-5 pb-1">
                  <button
                    class="btn btn-primary"
                    style="width: 200px"
                    type="submit"
                  >
                    Log in
                  </button>
                  
                </div>
                <div class="row">
                  <p style="color:#9e2725"><?php if(isset($msg))
                    {
                      
                    echo $msg;
                    }
                    ?></p>
                </div>

                <div
                  class="d-flex align-items-center justify-content-center pb-4"
                >
                  <p class="mb-0 me-2">Don't have an account?</p>
                  <a
                    href="register.php"
                    class="btn btn-outline-warning"
                    tabindex="-1"
                    role="button"
                    aria-disabled="true"
                    >Register</a
                  >
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
