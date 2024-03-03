<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
   $number=$_POST['number'];

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);
   
   
   

   if($select->rowCount() > 0){
      ?>
      <script>alert("Email already exist")</script>
      <?php
   }else{
      if($pass != $cpass){
         ?>
         <script>
            alert("password does not match")
            </script>
      <?php      
      }
      else{
         $insert = $conn->prepare("INSERT INTO `users`(name, email, number,password, image) VALUES(?,?,?,?,?)");
         $insert->execute([$name, $email,$number, $pass, $image]);
         if($insert){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               ?>
               <script>
               alert("registered successfully")
               </script>
               <?php
               header('location:login.php');
            }
         }

      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">
   
</head>
<body>

<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>
   
<section class="form-container">

   <form action="" enctype="multipart/form-data" method="POST">
      <h3>register now</h3>
      <input type="text" id="name" name="name" class="box" placeholder="enter your name" onblur="validateName()" required>
      <span id="name_error"></span>
      <input type="email"id="email" name="email" class="box" placeholder="enter your email" onblur="validateEmail()" required>
      <span id="email_error"></span>
      <input type="number" id="number" name="number" class="box" placeholder="enter your phone number" onblur="validateNumber()" required> 
      <span id="number_error"></span>
      <input type="password" id="pass" name="pass" class="box" placeholder="enter your password" onblur="validatePass()" required> 
      <span id="pass_error"></span>
     
      <input type="password" id="cpass" name="cpass" class="box" placeholder="confirm your password"  required>
      <span id="cpass_error"></span>
      <input type="file" id="image" name="image" class="box" onblur="checkImageSize()"  accept="image/jpg, image/jpeg, image/png">
      <span id="img_error"></span>
      <input type="submit" value="register now" class="btn" name="submit" onclick="validateConfirm()">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>
   
</section>
<script>
    
    function validateEmail() {
      const email = document.getElementById("email").value;
      const emailError = document.getElementById("email_error");

      // regular expression to validate email format
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!emailRegex.test(email)) {
        emailError.textContent = "Please enter a valid email address";
        document.getElementById("email").value="";
        emailError.style.color="red";
        
        document.getElementById("email").style.borderColor="red";
        
        
      } else {
        emailError.textContent = "";
        document.getElementById("email").style.borderColor = "initial";
      }
    }
    function validateName(){
      const name = document.getElementById("name").value;
    
      const emailError = document.getElementById("name_error");

      // regular expression to validate email format
      const emailRegex = /^[a-zA-Z]+$/;

      if (!emailRegex.test(name)) {
        emailError.textContent = "Name should not contain any digits or special character";
        document.getElementById("name").value="";
        emailError.style.color="red";
        
        document.getElementById("name").style.borderColor="red";
        
        
      } else {
        emailError.textContent = "";
        document.getElementById("name").style.borderColor = "initial";
      }
    }
    function validateNumber(){
      const number = document.getElementById("number").value;
    
      const emailError = document.getElementById("number_error");

      // regular expression to validate email format
      if(number.length<10){

      
        emailError.textContent = "number is not valid";
        document.getElementById("number").value="";
        emailError.style.color="red";
        
        document.getElementById("number").style.borderColor="red";
        
        
      } else {
        emailError.textContent = "";
        document.getElementById("number").style.borderColor = "initial";
      }
    }
    function validatePass(){
      const pass = document.getElementById("pass").value;
      
      
      const emailError = document.getElementById("pass_error");
      
      if(pass.length<8){
         emailError.textContent = "password should have atleast 8 letters";
        document.getElementById("pass").value="";
        emailError.style.color="red";
        
        document.getElementById("pass").style.borderColor="red";
      }

      // regular expression to validate email format
      else{
      const emailRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

      if (!emailRegex.test(pass)) {
        emailError.textContent = "Password should contain at least one uppercase letter, one lowercase letter, one digit, and one special character";
        document.getElementById("pass").value="";
        emailError.style.color="red";
        
        document.getElementById("pass").style.borderColor="red";
        
        
      } else {
        emailError.textContent = "";
        document.getElementById("pass").style.borderColor = "initial";
      }
    }
   }

  function checkImageSize() {
    const imageInput = document.getElementById('image');
    const errorMessage = document.getElementById('img_error');
    
    const file = imageInput.files[0];
    const fileSize = file.size / 1024; // Convert bytes to kilobytes
    const maxSize = 2048; // Maximum size in kilobytes
    
    if (fileSize > maxSize) {
      errorMessage.textContent = 'Please upload an image smaller than 2MB.'; // Change the message as per your requirement
      document.getElementById("image").style.borderColor="red";
      errorMessage.style.color="red";
      imageInput.value = ''; // Reset the input field
    } else {
      errorMessage.textContent = ''; // Clear the error message
    }
  }


    

    
  </script>


</body>
</html>