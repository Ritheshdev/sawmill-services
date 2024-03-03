<?php
require_once 'config.php';
require_once 'tcpdf/tcpdf.php';
//



if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   header('location:admin_users.php');

}

try {
    if(isset($_GET['order_id'])){
   $order_id=$_GET['order_id'];
   $select_cart = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
   $select_cart->execute([$order_id]);
   if ($select_cart->rowCount() > 0) {
      $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
      $pdf->SetCreator('Your Creator');
      $pdf->SetAuthor('Your Author');
      $pdf->SetTitle('Invoice');
      $pdf->SetSubject('Invoice');
      $pdf->SetKeywords('Invoice, PDF');
      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);

      while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
         if($fetch_cart['method']==='cash on delivery'){
         ob_start(); // Start output buffering
         ?>
         <div class="invoice-container">
            <div class="invoice-box">
               <div class="invoice-header">
                  <h1>NIRMALA SAW MILL</h1>
                  <p>Invoice ID: <?= $fetch_cart['id']; ?></p>
                  <p>Placed On: <?= $fetch_cart['placed_on']; ?></p>
               </div>

               <table class="invoice-details" border="1">
                  <tr>
                     <th>Name</th>
                     <td><?= $fetch_cart['name']; ?></td>
                  </tr>
                  <tr>
                     <th>Number</th>
                     <td><?= $fetch_cart['number']; ?></td>
                  </tr>
                  <tr>
                     <th>Email</th>
                     <td><?= $fetch_cart['email']; ?></td>
                  </tr>
                  <tr>
                     <th>Address</th>
                     <td><?= $fetch_cart['address']; ?></td>
                  </tr>
               </table>


               <p>Order Details</p>

               <table class="invoice-products" border="1">
                  <tr>
                     <th>Product</th>
                     <th>Quantity</th>
                     <th>Price</th>
                  </tr>
                  <?php
                  // Fetch product details from the database
                // Fetch product details from the database
               
                  // Rest of the code...
                  $total_products = explode(',', $fetch_cart['total_products']); // Split the string into an array

                  $products = explode(',', $fetch_cart['products_price']); // Split the string into an array
                  $quantity=explode(',',$fetch_cart['quantity']);

                  $count = count($total_products); // Get the count of elements

                  for ($i = 0; $i < $count; $i++) {
                  ?>
                  <tr>
                  <td><?= $total_products[$i];?></td>
                  <td><?= $quantity[$i];?></td>
                  <td>Rs <?= $products[$i];?></td>
                </tr>
        <?php
    }
    ?>
                  <tr>
                     <td colspan="2" align="right">Total:  </td>
                     <td>Rs <?= $fetch_cart['total_price']; ?></td>
                  </tr>
               </table>
               <div class="invoice-footer">
                  <p>GST Transaction ID: <?= generateGSTTransactionID(); ?></p>
               </div>
            </div>
         </div>
         <?php
         $html = ob_get_clean(); // Get and clean output buffer

         $pdf->AddPage();
         $pdf->writeHTML($html, true, false, true, false, '');
   
      

      $pdf->Output('invoice.pdf', 'I');
         }
         else { ?>
               <div class="invoice-container">
            <div class="invoice-box">
               <div class="invoice-header">
                  <h1>NIRMALA SAW MILL</h1>
                  <p>Invoice ID: <?= $fetch_cart['id']; ?></p>
                  <p>Placed On: <?= $fetch_cart['placed_on']; ?></p>
               </div>

               
               <table class="invoice-details" border="1">
                  <tr>
                     <th>Name</th>
                     <td><?= $fetch_cart['name']; ?></td>
                  </tr>
                  <tr>
                     <th>Number</th>
                     <td><?= $fetch_cart['number']; ?></td>
                  </tr>
                  <tr>
                     <th>Email</th>
                     <td><?= $fetch_cart['email']; ?></td>
                  </tr>
                  <tr>
                     <th>Address</th>
                     <td><?= $fetch_cart['address']; ?></td>
                  </tr>
               </table>


               <p>Order Details</p>

               <table class="invoice-products" border="1">
                  <tr>
                     <th>Product</th>
                     <th>Quantity</th>
                     <th>Price</th>
                  </tr>
                  <?php
                  // Fetch product details from the database
                // Fetch product details from the database
               $cart_id = $fetch_cart['id']; // Corrected variable name
               //$select_cart_items = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
               //$select_cart_items->execute([$fetch_cart['id']]);
               //while ($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)) {
                  // Rest of the code...
                  $total_products = explode(',',$fetch_cart['total_products']); // Split the string into an array

                  $products= explode(',',$fetch_cart['products_price']); // Split the string into an array
                  $quantity=explode(',',$fetch_cart['quantity']);

                  $count = count($total_products); // Get the count of elements

                  for ($i = 0; $i < $count; $i++) {
                  ?>
                  <tr>
                  <td><?= $total_products[$i];?></td>
                  <td><?= $quantity[$i];?></td>
                  <td>Rs <?=$products[$i];?></td>
                </tr>
        <?php
    }
   
    ?>
                  <tr>
                     <td colspan="2" align="right">Total:  </td>
                     <td>Rs<?= $fetch_cart['total_price']; ?></td>
                  </tr>
               </table>
               <p>Card Details</p>

               <table class="invoice-products" border="1">
                  <tr>
                     <th>Payment mode</th>
                     <th>Name</th>
                     <th>Card Number</th>
                     <th>Payment Date</th>
                  </tr>
                  <tr>
                  <td><?= $fetch_cart['method'];?></td>
                  <td><?= $fetch_cart['cname'];?></td>
                  <td><?php echo str_repeat("*", strlen($fetch_cart['cnumber']) - 4) . substr($fetch_cart['cnumber'], -4); ?></td>
                  <td><?=$fetch_cart['placed_on'];?></td>
                </tr>
               </table>

               <div class="invoice-footer">
                  <p>GST Transaction ID: <?= generateGSTTransactionID(); ?></p>
               </div>
            </div>
         </div>
         <?php
         $html = ob_get_clean(); // Get and clean output buffer

         $pdf->AddPage();
         $pdf->writeHTML($html, true, false, true, false, '');
      }
   }
      

      $pdf->Output('invoice.pdf', 'I');
   }
 } else {
      echo '<p class="empty">No orders placed yet!</p>';
   }

} catch (PDOException $e) {
   echo 'Error: ' . $e->getMessage();
}

/**
 * Generate a unique GST transaction ID
 * @return string
 */
function generateGSTTransactionID() {
   // Generate a unique ID using timestamp and random numbers
   $transaction_id = 'GST-' . time() . '-' . mt_rand(1000, 9999);
   return $transaction_id;
}
?>
