<?php
    include_once("config.php");
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require ('PHPmailer/Exception.php');
    require ('PHPmailer/SMTP.php');
    require ('PHPmailer/PHPMailer.php');
    // Connection Created Successfully
    $errors = [];
    session_start();
   

    // if forgot button will clicked
    if (isset($_POST['forgot_password'])) {
        $email = $_POST['email'];
        $_SESSION['email'] = $email;

        $emailCheckQuery = $conn->prepare("SELECT * FROM users WHERE email =?");
        $emailCheckQuery->execute([$email]);

        // if query  user_form
        if ($emailCheckQuery) {
            // if email matched
            if ($emailCheckQuery->rowCount() > 0) {
                 $code = rand(999999, 111111);
                 $updateQuery =$conn->prepare("UPDATE users SET code = ?, otp_expiry = DATE_ADD(NOW(), INTERVAL 1 MINUTE) WHERE email = ?");
                $updateQuery->execute([$code,$email]);
                if ($updateQuery) {
                    $mail = new PHPMailer();
                    //$code = rand(999999, 111111);
                
                    // Store All Errors user_form
                    $errors = [];
                      // SMTP configuration
                      $mail->isSMTP();
                      $mail->Host = 'smtp.gmail.com';
                      $mail->SMTPAuth = true;
                      $mail->Username = 'ritheshdevadiga2000@gmail.com'; // Your email address
                      $mail->Password = 'gxqddqisnijsqsiq'; // Your email password
                      $mail->SMTPSecure = 'tls';
                      $mail->Port = 587;
                  
                      // Sender and recipient information
                      $mail->setFrom('ritheshdevadiga2000@gmail.com', 'Your Name');
                      $mail->addAddress($email);
                  
                      // Email subject and body
                      $mail->isHTML(true);
                      $mail->Subject = 'Password Reset OTP Verification';
                      $mail->Body = "Your OTP for password reset is: $code<br>Please enter this OTP in the verification form.";
                    $mail->send();
                      $_SESSION['message'] = $message;
                      header('location: verifyEmail.php');
                } else {
                    $errors['db_errors'] = "Failed while inserting data into database!";
                }
            }else{
                $errors['invalidEmail'] = "Invalid Email Address";
            }
        }else {
            $errors['db_error'] = "Failed while checking email from database!";
        }
    }
    

// check if the reset button is clicked
if(isset($_POST['Resend'])) {


  header("Location: forgot.php");
  exit();
}


        
    


if(isset($_POST['verifyEmail'])){
    $_SESSION['message'] = "";
    $OTPverify = $_POST['OTPverify'];
    $verifyQuery = $conn->prepare("SELECT * FROM users WHERE code = ? AND otp_expiry > NOW()");
    $verifyQuery->execute([$OTPverify]);
    if($verifyQuery){
        if($verifyQuery->rowCount() > 0){
            

            $newQuery = $conn->prepare("UPDATE users SET code = 0, otp_expiry = NULL WHERE code = ?"); // set code to 0 and remove expiry time
            $newQuery->execute([$OTPverify]);
            header("location: newPassword.php");
        }else{
            $errors['verification_error'] = "Invalid Verification Code or otp expired";
        }
    }else{
        $errors['db_error'] = "Failed while checking Verification Code from database!";
    }
}

// change Password
if(isset($_POST['changePassword'])){
    $password =  $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    
    
    if(strlen($_POST['password'])<8){
        $error['password']='Password should conatain atleast 8 characters';   
     }
     elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', $_POST['password'])) {
        $error['password'] = "Password should contain at least one uppercase letter, one lowercase letter, one digit, and one special character";
     } 
     else {
        // if password not matched so
        if ($_POST['password']= $_POST['confirmPassword']) {
            $errors['password_error'] = 'Password not matched';
        } else {
            $query=$conn->prepare("SELECT * from users WHERE password=?");
            $query->execute([$password]);
            if($query->rowCount()>0){
                $error['password']='password already exist';
            }else{
            $email = $_SESSION['email'];
            $updatePassword = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $updatePassword->execute([$password,$email]) or die("Query Failed");
           //s session_unset($email);
            session_destroy();
            header('location: login.php');
        }
    }
    }
}


?>













