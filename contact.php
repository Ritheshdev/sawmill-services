<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['send'])){

   //$name = $_POST['name'];
   //$name = filter_var($name, FILTER_SANITIZE_STRING);
   //$email = $_POST['email'];
   
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);
   $rating = $_POST['rating']; // Get the value of the selected radio button

   $sql = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    if ($sql->execute([$user_id])) {
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $name = $row['name'];
        $email = $row['email'];
        $number = $row['number'];

        $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ? AND rating = ?");
        $select_message->execute([$name, $email, $number, $msg, $rating]);
     
   if($select_message->rowCount() > 0){
      $message[] = 'already sent feedback!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, message, rating) VALUES(?,?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg, $rating]);

      $message[] = 'sent message successfully!';

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
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="contact">

   <h1 class="title">get in touch</h1>

   <form action="" method="POST">
      <!--<input type="text" name="name" class="box" required placeholder="enter your name">
      <input type="email" name="email" class="box" required placeholder="enter your email">!-->
      <!--<input type="number" name="number" min="0" class="box" required placeholder="enter your number">-->
      <textarea name="msg" class="box" required placeholder="enter your message" cols="30" rows="10"></textarea>
      <div class="rating">
         <p>How do you rate this site?</p>
      <input type="radio" id="good" name="rating" value="good" required>
      <label for="good">Good</label>

      <input type="radio" id="average" name="rating" value="average" required>
      <label for="average">Average</label>

      <input type="radio" id="bad" name="rating" value="bad" required>
      <label for="bad">Bad</label>
   </div>
      <input type="submit" value="send feedback" class="btn" name="send">
   </form>

</section>








<?php include '../footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>