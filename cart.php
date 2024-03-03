<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$delete_id]);
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

if(isset($_POST['update_qty'])){
   $product_id = $_POST['product_id'];
    $query=$conn->prepare("SELECT `quantity` FROM `products` WHERE id = ? ");
    $query->execute([$product_id]);
    $executequery=$query->fetch(PDO::FETCH_ASSOC);
    $availableqty=$executequery['quantity'];

   $cart_id = $_POST['cart_id'];
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);
   if($p_qty > $availableqty){
      $message[] =  "only $availableqty available";
      
   }else{
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$p_qty, $cart_id]);
   $message[] = 'cart quantity updated';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="shopping-cart">

   <h1 class="title">products added</h1>

   <div class="box-container">

   <?php
      $grand_total = 0;
      
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){ 
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $select_products->execute([$fetch_cart['pid']]);
        $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
        $is_quantity_available = $fetch_product['quantity'] > 0; // Check if quantity is greater than 0

        // If quantity is 0, set a CSS class to disable the container
        $container_class = $is_quantity_available ? 'box' : 'box disabled';

        // If quantity is 0, set a CSS class to disable the Buy button
        $buy_button_class = $is_quantity_available ? 'btn' : 'btn disabled';

   if($fetch_product['quantity']>0){ 
   ?>
   <form action="" method="POST" class="box">
      <a href="cart.php?delete=<?= $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
      <a href="view_page.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
      <div class="name"><?= $fetch_cart['name']; ?></div>
      <div class="price">₹<?= $fetch_cart['price']; ?>/-</div>
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <input type="hidden" name="product_id" value="<?= $fetch_cart['pid']; ?>">
      <?php
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$fetch_cart['pid']]);
      $fetch_product=$select_products->fetch(PDO::FETCH_ASSOC);
      if($fetch_product['quantity']<5){?>
         <p style="color:red">*Only few left</p>
         <?php } ?>
      <div class="flex-btn">
         <input type="number" min="1" value="<?= $fetch_cart['quantity']; ?>" class="qty" name="p_qty">
         <input type="submit" value="update" name="update_qty" class="option-btn">
         <a href="quickcheckout.php?pid=<?= $fetch_cart['pid']; ?>" class="btn <?= ($sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']) > 1)?'':'disabled'; ?>">Buy</a>
         
      </div>
      <div class="sub-total"> sub total : <span>₹<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
   </form>
   <?php
      $grand_total += $sub_total;
      }
   else{ 
      $quantity=0;
      $pid=$fetch_cart['pid'];
      $update_query = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE pid = ?");
   $update_query->execute([$quantity, $pid]);
    ?>
      <form action="" method="POST" class="box disabled">
      <a href="cart.php?delete=<?= $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
      <a href="view_page.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
      <div class="name"><?= $fetch_cart['name']; ?></div>
      <div class="price">₹<?= $fetch_cart['price']; ?>/-</div>
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <input type="hidden" name="product_id" value="<?= $fetch_cart['pid']; ?>">
      <?php
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$fetch_cart['pid']]);
      $fetch_product=$select_products->fetch(PDO::FETCH_ASSOC);
      if($fetch_product['quantity']<5){?>
         <p style="color:red">*Only few left</p>
         <?php } ?>
      <div class="flex-btn">
         <input type="number" min="1" value="<?= $fetch_cart['quantity']; ?>" class="qty" name="p_qty">
         <input type="submit" value="upadte" name="update_qty" class="option-btn">
         <a href="quickcheckout.php?pid=<?= $fetch_cart['pid']; ?>" class="btn <?= ($sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']) > 1)?'':'disabled'; ?>">Buy</a>
         
      </div>
      <div class="sub-total"> sub total : <span>₹<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
   </form>
   
   <?php }
         }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   </div>

   <div class="cart-total">
      <p>grand total : <span>₹<?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">continue shopping</a>
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>">delete all</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div>

</section>








<?php include '../footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>