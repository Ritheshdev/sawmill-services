<?php include_once ("controller.php"); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Your Password In Php</title>
    <link rel="stylesheet" href="forgot.css">
</head>

<body>
    <div id="container">
        <h3>Check if your email is registerd with us...!</h3>
        <!-- <p>It's quick and easy.</p> -->
        <div id="line"></div>
        <h5>Enter your Email:</h2>
        <form action="forgot.php" method="POST" autocomplete="off">
            <?php
            if ($errors > 0) {
                foreach ($errors as $displayErrors) {
            ?>
                    <div id="alert"><?php echo $displayErrors; ?></div>
            <?php
                }
            }
            ?>
            <input type="email" name="email" placeholder="example@gmail.com"><br>
            <input type="submit" name="forgot_password" value="Check">
            
        </form>
    </div>
</body>

</html>