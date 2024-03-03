<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_POST['update_order'])) {

   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
   $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_orders->execute([$update_payment, $order_id]);
   $message[] = 'Payment has been updated!';

};

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_orders->execute([$delete_id]);
   header('location:admin_orders.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

   <?php include 'admin_header.php'; ?>

   <section class="placed-orders">

      <h1 class="title1">Placed Orders</h1>

      <div class="box-container1">

         <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            if ($select_orders->rowCount() > 0) {
         ?>
         <table >
            <thead>
               <tr>
                  <th>Order ID</th>
                  <th>User ID</th>
                  <th>Placed On</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Number</th>
                  <th>Address</th>
                  <th>Total Products</th>
                  <th>Quantity</th>
                  <th>Total Price</th>
                  <th>Payment Method</th>
                  <th>Payment Status</th>
                  <th>Invoice</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <tr>
                  <td><?= $fetch_orders['id']; ?></td>
                  <td><?= $fetch_orders['user_id']; ?></td>
                  <td><?= $fetch_orders['placed_on']; ?></td>
                  <td><?= $fetch_orders['name']; ?></td>
                  <td><?= $fetch_orders['email']; ?></td>
                  <td><?= $fetch_orders['number']; ?></td>
                  <td><?= $fetch_orders['address']; ?></td>
                  <td><?= $fetch_orders['total_products']; ?></td>
                  <td><?= $fetch_orders['quantity']; ?></td>
                  <td>₹<?= $fetch_orders['total_price']; ?>/-</td>
                  <td><?= $fetch_orders['method']; ?></td>
                  <td><?= $fetch_orders['payment_status']; ?></td>
                  <td><a href="admininv.php?order_id=<?= $fetch_orders['id']; ?>"class="invoice-btn">Download Invoice</a></td>
                   <td>
                     <form action="" method="POST">

                        <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                        <select name="update_payment" class="drop-down">
                           <option value="<?=$fetch_orders['payment_status']; ?>"></option>
                           <option value="pending">Pending</option>
                           <option value="completed">Completed</option>
                        </select>
                        <div class="flex-btn1">
                           <input type="submit" name="update_order" class="option-btn1" value="Update">
                           <a href="admin_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn1" onclick="return confirm('Delete this order?');">Delete</a>
                        </div>
                     </form>
                  </td>
               </tr>
               <?php
                  }
               ?>
            </tbody>
         </table>
         <style>
            /* CSS for the table */
table {
   width: 100vw;
   border-collapse: collapse;
   margin-top: 20px;
   width: 100%;
    max-width: 1200px;
}

table th,
table td {
   padding: 10px;
   text-align: left;
   border-bottom: 1px solid #ccc;
   background-color:antiquewhite;

   
   
}

table th {
   background-color:#4caf50;
   font-weight: bold;
}

table td span {
   font-weight: bold;
   background-color:antiquewhite;
}

/* CSS for the buttons */
.flex-btn1 {
   display: flex;
   justify-content: space-between;
   align-items: center;
   margin-top: 10px;
}

.option-btn1,
.delete-btn1 {
   padding: 6px 12px;
   border-radius: 4px;
   cursor: pointer;
}

.option-btn1 {
   background-color: #4caf50;
   color: #fff;
   border: none;
}

.delete-btn1 {
   background-color: #f44336;
   color: #fff;
   border: none;
}

.delete-btn1:hover {
   background-color: #ff5252;
}
.invoice-btn {
   color:blue;
}


/* CSS for the empty message */
.empty {
   margin-top: 20px;
   text-align: center;
   font-weight: bold;
   color: #888;
}


         </style>
         <?php
            } else {
               echo '<p class="empty">No orders placed yet!</p>';
            }
         ?>

      </div>

   </section>

   <script src="js/script.js"></script>

</body>
</html>
