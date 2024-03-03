<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
   exit();
}

if (isset($_POST['order'])) {
   $select_user=$conn->prepare("SELECT id,name,email,number from `users` where id=?");
   $select_user->execute([$user_id]);
   $fetch_user=$select_user->fetch(PDO::FETCH_ASSOC);
   $name=$fetch_user['name'];
   $email=$fetch_user['email'];
   $number=$fetch_user['number'];

   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. ' . $_POST['flat'] . ' ' . $_POST['street'] . ' ' . $_POST['city'] . ' ' . $_POST['state'] . ' ' . $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $placed_on = date('d-M-Y');
   $cart_total = 0;
   $cart_products = [];

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query->execute([$user_id]);
   if ($cart_query->rowCount() > 0) {
      while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
         $cart_products[]=$cart_item['name'];
         $cart_quantity[]=$cart_item['quantity'];

         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $sub_product[]=$sub_total;
         $cart_total += $sub_total;
      }
   }
   $product_price=implode(',',$sub_product);
   $product_quantity=implode(',',$cart_quantity);
   $total_products=implode(",",$cart_products);

   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND products_price = ? AND quantity = ? AND total_products = ? AND total_price = ?");
   $order_query->execute([$name, $number, $email, $method, $address,$product_price,$product_quantity, $total_products, $cart_total]);

   if ($cart_total == 0) {
      $message[] = 'Your cart is empty.';
   } elseif ($order_query->rowCount() > 0) {
      $message[] = 'Order already placed!';
   } else {
       // Set the image variable to an empty string
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, products_price ,quantity, total_products, total_price, placed_on) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address,$product_price,$product_quantity,$total_products, $cart_total, $placed_on]);
      $_SESSION['id'] = $conn->lastInsertId();
      
      $cart_query1 = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query1->execute([$user_id]);
   if ($cart_query1->rowCount() > 0) {
      while ($cart_item1 = $cart_query1->fetch(PDO::FETCH_ASSOC)) {
         $pid=$cart_item1['pid'];
         $query = $conn->prepare("SELECT * FROM `products`where id=?");
         $query->execute([$pid]);
         $fetch_qty=$query->fetch(PDO::FETCH_ASSOC);
         $actualqty=$fetch_qty['quantity'];
         $cart_quantity1=$cart_item1['quantity'];
         $productqty=$actualqty-$cart_quantity1;

      $update_product = $conn->prepare("UPDATE `products` SET quantity = ? WHERE id = ?");
      $update_product->execute([$productqty,$pid]);
      }
   }
  
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
      $message[] = 'Order placed successfully!';
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
   <title>Checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="display-orders">

   <?php
   $cart_grand_total = 0;
   $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND quantity > 0");
   $select_cart_items->execute([$user_id]);
   if ($select_cart_items->rowCount() > 0) {
      while ($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)) {
         $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
         $cart_grand_total += $cart_total_price;
   ?>
         <p><?= $fetch_cart_items['name']; ?> <span>(<?= '₹' . $fetch_cart_items['price'] . '/- x ' . $fetch_cart_items['quantity']; ?>)</span></p>
   <?php
      }
   } else {
      echo '<p class="empty">Your cart is empty!</p>';
   }
   ?>
   <div class="grand-total">Grand total: <span>₹<?= $cart_grand_total; ?>/-</span></div>
</section>

<section class="checkout-orders">



   <form action="" method="POST">

      <h3>Place Your Order</h3>

      <div class="flex">
         <!-- <div class="inputBox">
            <span>Your Name:</span>
            <input type="text" name="name" placeholder="Enter your name" class="box" required>
         </div>
         <div class="inputBox">
            <span>Your Number:</span>
            <input type="number" name="number" placeholder="Enter your number" class="box" required>
         </div>
         <div class="inputBox">
            <span>Your Email:</span>
            <input type="email" name="email" placeholder="Enter your email" class="box" required>
         </div> -->
         <div class="inputBox">
            <span>Payment Method:</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Cash on Delivery</option>
               <option value="credit card">Credit Card</option>
               
            </select>
         </div>
         <div class="inputBox">
            <span>Address Line 01:</span>
            <input type="text" name="flat" placeholder="e.g. Flat Number" class="box" required>
         </div>
         <div class="inputBox">
            <span>Address Line 02:</span>
            <input type="text" name="street" placeholder="e.g. Street Name" class="box" required>
         </div>
         <div class="inputBox">
            <span>City:</span>
            <input type="text" name="city" placeholder="e.g. Mumbai" class="box" required>
         </div>
         <div class="inputBox">
            <span>State:</span>
            <input type="text" name="state" placeholder="e.g. Maharashtra" class="box" required>
         </div>
         <!-- <div class="inputBox">
            <span>Country:</span>
            <input type="text" name="country" placeholder="e.g. India" class="box" required>
         </div> -->
         <div class="inputBox">
            <span>Pin Code:</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" class="box" required>
            <php window.location.href = "place_order.php";?>
         </div>
      </div>

      <input type="submit"  name="order" class="btn <?= ($cart_grand_total > 1) ? '' : 'disabled'; ?>" value="Place Order">

    
   </form>
</section>

<?php include '../footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
