<?php
// header("Location: homepage.php");


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
$addresline1 = $_POST['xxadd1'];
$addresline2 = $_POST['xxadd2'];
$city = $_POST['xxcity'];
$province = $_POST['xxprovince'];
$zip = $_POST['xxzip'];
$jid = $_POST['xxjtitle'];
$dpt = $_POST['xxdpt'];
$paygrade = $_POST['xxpaygrade'];
$status = $_POST['xxstatus'];
$bnkname = $_POST['xxbnkname'];
$brnchname = $_POST['xxbrnchname'];
$accn = $_POST['xxaccn'];
$query = "SELECT * FROM custom_attribute";
$result = $conn->query($query);
$customs = '';
$marks = '';
$strings = '';
$values = array();
if ($result->num_rows > 0) {
    $customs = '';
    $marks = '';
    $strings = '';
    $values = array();
    while ($row = $result->fetch_assoc()) {
        $attr_name = $row['name'];
        $marks .= ',?';
        $strings .= 's';
        array_push($values, $_POST[$attr_name]);
    }
}

$id = '20001';
$generated_password = time() . $id;
$passw = md5($generated_password . $id);
$usertype = 'admin';
$img = 'default.jpg';

$employee = $conn->prepare("INSERT INTO employee VALUES (?,?,?, ?, ?,?,?,?".$marks.")");
$employee->bind_param("ssisssss".$strings, $fname,$lname,$id, $gender, $phone,$email,$bdate,$marital,...$values);

$user = $conn->prepare("INSERT INTO user (user_name,id,password,user_type,img_name) VALUES (?,?,?,?,?)");
$user->bind_param("issss", $id, $id, $passw, $usertype, $img);

$address = $conn->prepare("INSERT INTO address VALUES (?,?,?,?,?,?)");
$address->bind_param("isssss", $id, $addresline1, $addresline2, $city, $province, $zip);

$employment = $conn->prepare("INSERT INTO employment VALUES (?,?,?,?,?)");
$employment->bind_param("issss", $id, $jid, $paygrade, $status, $dpt);

$bank = $conn->prepare("INSERT INTO bank_details VALUES (?,?,?,?)");
$bank->bind_param("isss", $id, $bnkname, $brnchname, $accn);


try {
    $conn->begin_transaction();
    $employee->execute();
    $user->execute();
    $address->execute();
    $employment->execute();
    $bank->execute();
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
$conn->commit();

// fesvwwwweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee

// if (isset($_POST['flag'])) {
//     $generated_password = time() . $id;
//     $passw = md5($generated_password . $id);
//     $usertype = 'user';
//     $img = 'default.jpg';
//     $user = $conn->prepare("INSERT INTO user (user_name,id,password,user_type,img_name) VALUES (?,?,?,?,?)");
//     $user->bind_param("issss", $id, $id, $passw, $usertype, $img);
//     try {
//         $conn->begin_transaction();
//         $user->execute();
//     } catch (Exception $e) {
//         $conn->rollback();
//         echo "Error: " . $e->getMessage();
//     }
//     $conn->commit();
// }
// frrwsevseeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee

echo $id;
echo $generated_password = time() . $id;

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
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
