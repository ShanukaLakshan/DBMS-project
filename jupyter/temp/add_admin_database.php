<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('admin_config.php');

$conn = mysqli_connect($sname, $uname, $password, $db_name);
$fname = $_POST['xxfname'];
$lname = $_POST['xxlname'];
$gender = $_POST['xxgender'];
$phone = $_POST['xxphone'];
$email = $_POST['xxemail'];
$bdate = $_POST['xxbdate'];
$marital = $_POST['xxmarital'];

// $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM employee ORDER BY id DESC LIMIT 1"));
// $id = $row['id']+1;

$id = 20000;

$generated_password = time() . $id;
$passw = md5($generated_password . $id);
$usertype = 'admin';
$img = 'default.jpg';

$sql1 = mysqli_query($conn, "alter table employee auto_increment = 20000");

$employee = $conn->prepare("INSERT INTO employee (first_name,last_name,gender,phone_number,email,birth_date,marital_status) VALUES (?,?, ?, ?,?,?,?)");
$employee->bind_param("sssssss", $fname, $lname, $gender, $phone, $email, $bdate, $marital);

$user = $conn->prepare("INSERT INTO user (user_name,id,password,user_type,img_name) VALUES (?,?,?,?,?)");
$user->bind_param("issss", $id, $id, $passw, $usertype, $img);

try {
    $conn->begin_transaction();
    $employee->execute();
    $user->execute();
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
$conn->commit();

// echo $id;
// echo $generated_password = time() . $id;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'vengenz128@gmail.com';
    $mail->Password   = 'hugnuhkquetujlih'; // need to change
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('vengenz128@gmail.com', 'Jupiter Apperals');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Subject';

    $mail->Body = '
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Document</title>
    </head>
    
    <body>
      
        <div >
            <div>
                <h1>Hi, ' . $fname . '</h1>
                <h3>Thank you for joining our company as a new Admin. Your user name is ' . $id . ' and your password is ' . $generated_password . '.</h2> 
            </div>
            
            </div>
      </div>
    </body>
    
    </html>
    ';
    $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    $mail->send();
    // echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
echo "<script>window.location.assign('homepage.php')</script>";
?>