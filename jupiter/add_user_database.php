<?php
header("Location: homepage.php");
include('admin_config.php');

$conn = mysqli_connect($sname, $uname, $password, $db_name);
$fname = $_POST['xxfname'] ;
$lname= $_POST['xxlname'];
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
$sid = $_POST['xxsid'];
$query = "SELECT * FROM custom_attribute";
$customs='';
$marks='';
$strings='';
$values=array();
$result = $conn->query($query);
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $attr_name = $row['name'];
        $marks.=',?';
        $strings.='s';
        array_push($values, $_POST['xx'.$attr_name]);
    }
}
// $sql1 = "INSERT INTO employee (name,gender,phone_number,email,birth_date,marital_status) VALUES ('$name','$gender','$phone','$email','$bdate','$marital')";
$sql6 = "SELECT id FROM employee ORDER BY id DESC LIMIT 1";
if (!$conn) {
    echo "Connection Failed!";
    exit();
}

$eid = mysqli_query($conn, $sql6);
$row = mysqli_fetch_assoc($eid);
$id = $row['id']+1;
echo $marks;
$employee = $conn->prepare("INSERT INTO employee VALUES (?,?,?, ?, ?,?,?,?".$marks.")");
$employee->bind_param("ssisssss".$strings, $fname,$lname,$id, $gender, $phone,$email,$bdate,$marital,...$values);

$address=$conn->prepare("INSERT INTO address VALUES (?,?,?,?,?,?)");
$address->bind_param("isssss", $id, $addresline1, $addresline2,$city,$province,$zip);
$employment=$conn->prepare("INSERT INTO employment VALUES (?,?,?,?,?)");
$employment->bind_param("issss", $id, $jid,$paygrade,$status,$dpt);

$bank=$conn->prepare("INSERT INTO bank_details VALUES (?,?,?,?)");
$bank->bind_param("isss", $id, $bnkname, $brnchname,$accn);

$supervise=$conn->prepare("INSERT INTO supervisor VALUES (?,?)");
$supervise->bind_param("ii", $id, $sid);


// $sql2 = "INSERT INTO address VALUES ('$id','$addresline1','$addresline2','$province','$city','$zip')";

//$query2 = "SELECT DISTINCT id FROM department where name='" . $dpt . "'";
//$depart=mysqli_query($conn, $query2);
//$depa = mysqli_fetch_assoc($depart);
//$dpt_id=$depa['id'];
// $sql3 = "INSERT INTO employment VALUES ('$id','$jid','$paygrade','$status','$dpt')";

// $sql4 = "INSERT INTO bank_details VALUES ('$id','$bnkname','$brnchname','$accn')";
// $sql5 = "INSERT INTO supervisor VALUES ('$sid','$id')";
/*
try{
    $conn->begin_transaction();
    $employee->execute();
}
catch(Exception $e){
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
$conn->commit();
*/
try{
    $conn->begin_transaction();
    $employee->execute();
    $address->execute();
    $employment->execute();
    $bank->execute();
    $supervise->execute();
}
catch(Exception $e){
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
$conn->commit();
 /*  
if ($conn->query($sql2) === TRUE) {
    echo "\nNew address record created successfully\n";
} else {
    echo "Error: ";
}
if ($conn->query($sql3) === TRUE) {
    echo "\nNew employment record created successfully\n";
} else {
    echo "Error: ";
}
if ($conn->query($sql4) === TRUE) {
    echo "\nNew bank_details record created successfully\n";
} else {
    echo "Error: ";
}
if ($conn->query($sql5) === TRUE) {
    echo "\nNew supervisor record created successfully\n";
} else {
    echo "Error: ";
}
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// send user name and password to the user
if(isset($_POST['flag'])){
    $generated_password = time().$id;
    $passw=md5($generated_password.$id);
    $usertype='user';
    $img='default.jpg';
    $user=$conn->prepare("INSERT INTO user (user_name,id,password,user_type,img_name) VALUES (?,?,?,?,?)");
    $user->bind_param("issss", $id, $id,$passw ,$usertype, $img);
    try{
        $conn->begin_transaction();
        $user->execute();
    }
    catch(Exception $e){
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
    $conn->commit();
    // $sql6 = "INSERT INTO user (id,user_name,password,user_type,img_name) VALUES ('$id','$generated_username','$generated_password','user','default.jpg')";
    // if ($conn->query($sql6) === TRUE) {
    //     echo "\nUser added successfully\n";
    // } else {
    //     echo "Error: ";
    // }

    
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
                <h3>Thank you for joining our company. Your user name is ' . $id . ' and your password is ' . $generated_password . '.</h2> 
            </div>
            
            </div>
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
}