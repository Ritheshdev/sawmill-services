<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}
if (isset($_POST['delete_order'])) {
   $order_id = $_POST['order_id'];

   $currentDate = date("d-M-Y"); 
   $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
      $select_orders->execute([$order_id]);
      $fetch_orders=$select_orders->fetch(PDO::FETCH_ASSOC);
      $place_on_date = strtotime($fetch_orders['placed_on']);
      $method=$fetch_orders['method'];
   $current_date = time();
   $days_difference = floor(($current_date - $place_on_date) / (60 * 60 * 24)); // Calculate the difference in days

   // Delete the order if it was placed within 3 days
   if ($days_difference <= 3) {
      $status="cancelled";
   $cancel_order = $conn->prepare("UPDATE `orders`SET status= ? WHERE id = ?");
   $cancel_order->execute([$status,$order_id]);
   if($method=="credit card"){
      header('location:1cancel.html');

   }
   
   ?>
   <script>alert("Order cancelled succesfilly")</script>
   <?php

   } 
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="placed-orders">

   <h1 class="title">placed orders</h1>
   
   <div class="box-container">

   <?php
      $status="notcancelled";
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? AND status=?");
      $select_orders->execute([$user_id,$status]);
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      
      <a class="btn" href="admininv.php?order_id=<?= $fetch_orders['id'];?>">View Invoice</a>
      <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
      <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
      <p> your orders : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> total price : <span>₹<?= $fetch_orders['total_price']; ?>/-</span> </p>
      <p> payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
      <?php
                  // Display delete option for orders placed within 3 days
                  $place_on_date = strtotime($fetch_orders['placed_on']);
                  $current_date = time();
                  $days_difference = floor(($current_date - $place_on_date) / (60 * 60 * 24)); // Calculate the difference in days

                  if ($days_difference <= 3) {
                     ?>
                     <form method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                        <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                        <button type="submit" name="delete_order" class="btn">Delete Order</button>
                     </form>
                  <?php
                  }
                  ?>
               
      

   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no orders placed yet!</p>';
   }
   ?>

   </div>

</section>









<?php include '../footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>