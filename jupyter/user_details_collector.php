<?php
header("Location: index.html");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'shanukalakshan9817@gmail.com';
    $mail->Password   = 'ayzvbxldnlkyylru'; // need to change
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('shanukalakshan9817@gmail.com', 'Shanuka Lakshan');
    $mail->addAddress('sadeepaekanayaked@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Subject';
    /*
$mail->Body    = '
            <p>
            TEst : '.$_POST['fname'].'
            <br>
            Last Name : '.$_POST['lname'].'
            <br>
            Email : '.$_POST['email'].'
            <br>
            Gender : '.$_POST['gender'].'
            <br>
            Birthday : '.$_POST['bdate'].'
            <br>
            City : '.$_POST['city'].'
            <br>
            Province : '.$_POST['province'].'
            <br>
            Zip Code : '.$_POST['zip'].'
            <br>
            Job Title : '.$_POST['jtitle'].'
            <br>
            Department Name : '.$_POST['dpt'].'
            <br>
            Pay Grade : '.$_POST['paygrade'].'
            <br>
            Job Status : '.$_POST['status'].'
            <br>
            Bank Name : '.$_POST['bnkname'].'
            <br>
            Branch Name : '.$_POST['bncname'].'
            <br>
            Account Name : '.$_POST['accn'].'
            <br>
            </p>';
*/
    $mail->Body = '
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <title>Document</title>
</head>

<body>
  
    <form method="GET" class="border shadow p-3 rounded" action="http://localhost:8080/DBMS-project/jupyter/admin_add_user.php">
        <div class="mb-1">
            <label class="form-label">First Name</label>
                <input type="text" name="xfname" value="' . $_POST['fname'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Last Name</label>
                <input type="text" name="xlname" value="' . $_POST['lname'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Email</label>
                <input type="text" name="xemail" value="' . $_POST['email'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Birth Day</label>
                <input type="text" name="xbdate" value="' . $_POST['bdate'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Gender</label>
                <input type="text" name="xgender" value="' . $_POST['gender'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">City</label>
                <input type="text" name="xcity" value="' . $_POST['city'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Province</label>
                <input type="text" name="xprovince" value="' . $_POST['province'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Zip</label>
                <input type="text" name="xzip" value="' . $_POST['zip'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Job Title</label>
                <input type="text" name="xjtitle" value="' . $_POST['jtitle'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Department</label>
                <input type="text" name="xdpt" value="' . $_POST['dpt'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Pay Grade</label>
                <input type="text" name="xpaygrade" value="' . $_POST['paygrade'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Status</label>
                <input type="text" name="xstatus" value="' . $_POST['status'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Bank Name</label>
                <input type="text" name="xbnkname" value="' . $_POST['bnkname'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Branch Name</label>
                <input type="text" name="xbncname" value="' . $_POST['bncname'] . '"><br>        
        </div>
        <div class="mb-1">
            <label class="form-label">Account Number</label>
                <input type="text" name="xaccn" value="' . $_POST['accn'] . '"><br>        
        </div>
      <input class="btn btn-primary" type="submit" value="Approve Job">
    </form>
  </div>
</body>

</html>
';
    $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    $mail->send();
    echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


exit();
