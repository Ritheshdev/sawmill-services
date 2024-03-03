<?php
// credit_card_payment.php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
   header('Location: login.php');
   exit();
}

// Check if the order ID is set in the session
if (!isset($_SESSION['id'])) {
   header('Location: place_order.php');
   exit();
}

$order_id = $_SESSION['id'];

// Retrieve order details from the database
include 'config.php';

$order_query = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
$order_query->execute([$order_id]);
$order = $order_query->fetch(PDO::FETCH_ASSOC);
if($_SERVER['REQUEST_METHOD']==='POST'){
   $cname=$_POST['cardholder'];
   $cnumber=$_POST['cardnumber'];
   $expirymonth=$_POST['expmonth'];
   $expiryyear=$_POST['expyear'];
   $cvv=$_POST['cvv'];
   $status='completed';
   $update_query = $conn->prepare("UPDATE `orders` SET payment_status = ?, cname = ?, cnumber = ?, cmonth = ?, cyear = ?, cvv = ? WHERE id = ?");
   $update_query->execute([$status,$cname, $cnumber, $expirymonth, $expiryyear, $cvv, $order_id]);

   header("location:paymentsuccess.php");
   }

// Display order details
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Credit Card Payment</title>

   <style>
      * {
         box-sizing: border-box;
      }

      body {
         font-family: Arial, sans-serif;
         margin: 0;
         padding: 0;
         background-color: #f2f2f2;
      }

      section {
         max-width: 400px;
         margin: 50px auto;
         padding: 20px;
         background-color: #fff;
         border-radius: 5px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      h2 {
         text-align: center;
         color: #333;
         margin-bottom: 20px;
      }

      form {
         margin-top: 20px;
      }

      .inputBox {
         margin-bottom: 15px;
      }

      label {
         display: block;
         font-weight: bold;
         margin-bottom: 5px;
         color: #555;
      }

      input[type="text"] {
         width: 100%;
         padding: 10px;
         border: 1px solid #ccc;
         border-radius: 4px;
         font-size: 14px;
         transition: border-color 0.3s ease;
      }

      input[type="text"]:focus {
         border-color: #4caf50;
      }

      button[type="submit"] {
         display: block;
         width: 100%;
         padding: 10px;
         background-color: #4caf50;
         color: #fff;
         border: none;
         border-radius: 4px;
         font-size: 16px;
         cursor: pointer;
         transition: background-color 0.3s ease;
      }

      button[type="submit"]:hover {
         background-color: #45a049;
      }
   </style>
</head>
<body>
  
   <section>
      <h2>Credit Card Payment</h2>
      <p>Order ID: <?php echo $order['id']; ?></p>
      
      <!-- Add credit card payment form here -->
      <form action="credit_card_payment.php" method="POST">
      <div class="inputBox">
            <label for="Totalamount">Total amount:</label>
            <input type="text" name="amount" id="amount" value="₹<?php echo $order['total_price']; ?>" readonly style="color: red;">

         </div>
         <div class="inputBox">
            <label for="cardholder">Cardholder Name:</label>
            <input type="text" name="cardholder" id="cardholder" required pattern="[^\d\s]+" title="Cardholder name should not contain digits">
         </div>
         <div class="inputBox">
            <label for="cardnumber">Card Number:</label>
            <input type="text" name="cardnumber" id="cardnumber" required pattern="\d{15}" title="Card number should be a 15-digit number">
         </div>
         <div class="inputBox">
   <label for="expmonth">Expiry Month:</label>
   <select name="expmonth" id="expmonth" required>
      <option value="">Select Month</option>
      <option value="01">January</option>
      <option value="02">February</option>
      <option value="03">March</option>
      <!-- Add more month options if needed -->
   </select>
   <label for="expyear">Expiry Year:</label>
   <select name="expyear" id="expyear" required>
      <option value="">Select Year</option>
      <option value="2023">2023</option>
      <option value="2024">2024</option>
      <option value="2025">2025</option>
      <!-- Add more year options if needed -->
   </select>
</div>

         <div class="inputBox">
            <label for="cvv">CVV:</label>
            <input type="text" name="cvv" id="cvv" required pattern="\d{3}" title="invalid cvv number">
         </div>
         <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
         <button type="submit">Pay Now</button>
      </form>

   </section>
   
   
      

</body>
</html>
