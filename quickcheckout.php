<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};
if(isset($_POST['order'])){
   $pid=$_GET['pid'];

   $select_user=$conn->prepare("SELECT id,name,email,number from `users` where id=?");
   $select_user->execute([$user_id]);
   $fetch_user=$select_user->fetch(PDO::FETCH_ASSOC);
   $name=$fetch_user['name'];
   $email=$fetch_user['email'];
   $number=$fetch_user['number'];

   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .' '. $_POST['street'] .' '. $_POST['city'] .' '. $_POST['state'] .' '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   //$cart_products[] = '';

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND pid = ? ");
   $cart_query->execute([$user_id,$pid]);
   if($cart_query->rowCount() > 0){
      while($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
         $cart_products[] = $cart_item['name'];
         $cart_quantity[]=$cart_item['quantity'];

         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $sub_product[]=$sub_total;
         $cart_total += $sub_total;
      }
   }
   $product_price=implode(', ',$sub_product);
   $product_quantity=implode(', ',$cart_quantity);
   $total_products = implode(', ',$cart_products);

   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND products_price = ? AND quantity = ? AND total_products = ? AND total_price = ?");
   $order_query->execute([$name, $number, $email, $method, $address,$product_price,$product_quantity, $total_products, $cart_total]);

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }elseif($order_query->rowCount() > 0){
      $message[] = 'order placed already!';
   }else{
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, products_price ,quantity, total_products, total_price, placed_on) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address,$product_price,$product_quantity, $total_products, $cart_total, $placed_on]);
      $_SESSION['id'] = $conn->lastInsertId();

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ? AND pid=?");
      $delete_cart->execute([$user_id,$pid]);
      $message[] = 'order placed successfully!';
      if ($method == 'credit card') {
         header('location: credit_card_payment.php');
         exit();
      } else {
         header('location: place_order.php');
         exit();
      
      
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
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="display-orders">

   <?php
       $pid=$_GET['pid'];
      $cart_grand_total = 0;
      
      $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND pid = ?");
      $select_cart_items->execute([$user_id,$pid]);
      if($select_cart_items->rowCount() > 0){
         while($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)){
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
            $cart_grand_total += $cart_total_price;
   ?>
   <p> <?= $fetch_cart_items['name']; ?> <span>(<?= '₹'.$fetch_cart_items['price'].'/- x '. $fetch_cart_items['quantity']; ?>)</span> </p>
   <?php
    }
   }
   ?>
   <div class="grand-total">grand total : <span>₹<?= $cart_grand_total; ?>/-</span></div>
</section>

<section class="checkout-orders">

   <form action="" method="POST">

      <h3>place your order</h3>

      <div class="flex">
         <!-- <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" required>
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" required>
         </div> -->
         <div class="inputBox">
            <span>Payment Method:</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Cash on Delivery</option>
               <option value="credit card">Credit Card</option>
               
            </select>
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" required>
         </div>
         <div class="inputBox">
            <span>address line 02 :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" required>
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" placeholder="e.g. mumbai" class="box" required>
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" placeholder="e.g. maharashtra" class="box" required>
         </div>
         <!-- <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" placeholder="e.g. India" class="box" required>
         </div> -->
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" class="box" required>
            <php window.location.href = "place_order.php";?>
         </div>
         
      

      <input type="submit" name="order" class="btn <?= ($cart_grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>








<?php include '../footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>