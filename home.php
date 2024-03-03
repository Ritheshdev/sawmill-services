<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
  
   

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }
      $p_qty=1;
      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="home-bg">

   <section class="home">

      <div class="content">
         <span>Sabse Sasta,Sabse Accha</span>
         <h3>Reach For A Best Product With Best Quality</h3>
         <p>Nirmala Saw Mill which provides services of E-Shop from 1990, which provides Best Quality of Products For the Future<br>Shop Smarter,Not Harder with Nirmala E-shop</p>
         <a href="about.php" class="btn">about us</a>
      </div>

   </section>

</div>

<section class="home-category">

   <h1 class="title">shop by category</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/c1.jpg" alt="">
         <h3>Chair</h3>
         <p>"Introducing our sleek and stylish chair, designed with both comfort and elegance in mind. Made with high-quality materials and built to last, this chair is the perfect addition to any room. Whether you're working from home, reading a book, or enjoying a meal, our chair offers superior comfort and support. With its modern design and clean lines, it's sure to complement any home decor. Upgrade your seating experience with our beautiful chair today."</p>
         <a href="category.php?category=chair" class="btn">chair</a>
      </div>

      <div class="box">
         <img src="images/sofa1.jpg" alt="">
         <h3>Sofa</h3>
         <p>
"Experience ultimate comfort and style with our luxurious sofa. Made with the finest materials and crafted with attention to detail, this sofa is the perfect addition to any living space. Sink into the plush cushions and let your worries melt away as you relax in style. Whether you're hosting a movie night with friends or cuddling up with a good book, this sofa provides the perfect setting for all your favorite activities. Elevate your home decor and make a statement with our stunning sofa today</p>
         <a href="category.php?category=soafa" class="btn">soafa</a>
      </div>

      <div class="box">
         <img src="images/t1.jpg" alt="">
         <h3>Table</h3>
         <p>"Introducing our beautifully crafted table, designed with both style and function in mind. Made from high-quality materials, this table is not only durable but also adds a touch of elegance to any room. Whether you're entertaining guests or simply enjoying a meal with your family, this table provides ample space and comfort for all. Upgrade your home decor with our exquisite table today!</p>
         <a href="category.php?category=table" class="btn">table</a>
      </div>

      <div class="box">
         <img src="images/sofa2.jpg" alt="">
         <h3>Other</h3>
         <p>"Transform your living space into a haven of comfort and style with our stunning collection of furniture. From elegant tables to luxurious sofas and stylish chairs, our range of furniture is designed to meet your every need. Crafted with high-quality materials and attention to detail, our pieces are built to last and add a touch of sophistication to any room. Whether you're looking to upgrade your home decor or simply create a cozy space for your family, our furniture collection has something for everyone. Elevate your living experience with our exquisite furniture today."</p>
         <a href="category.php?category=other" class="btn">other</a>
      </div>

   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
    <?php if ($fetch_products['quantity'] > 0) { ?>
   <form action="" class="box" method="POST">
      <div class="price">₹<span><?= $fetch_products['price']; ?></span>/-</div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <div class="productcontainer">
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="" class="product-image"></div>      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
      <?php if($fetch_products['quantity']<5){?>
         <p style="color:red">*Only few left </p>
         <?php } ?>

      
      <!-- <input type="number" min="1" value="1" name="p_qty" class="qty"> -->
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php } else { ?>
      <div class="box disabled">
      <form action="" class="box" method="POST">
      <div class="price">₹<span><?= $fetch_products['price']; ?></span>/-</div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
      <input type="number" min="1" value="1" name="p_qty" class="qty">
      <p class="name" style="color:red">Out of Stock</p>
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   
        </div>


 
        <?php 
   }
}
      
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

</section>







<?php include '../footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>