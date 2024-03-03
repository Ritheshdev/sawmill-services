<!DOCTYPE html>
<html>
<head>
<style>
    table {
        width: 50%;
        border-collapse: collapse;
    }

    table th,
    table td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    table th {
        background-color: #FFFFFF;
        font-weight: bold;
    }

    table tr:nth-child(even) {
        background-color: #5CB3FF;
    }

    table tr:hover {
        background-color:#ccc;
    }

    table img {
        max-width: 100px;
    }

    .btn {
        background-color: darkgreen;
    }

    .navbar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        background-color: #f2f2f2;
        padding: 10px;
    }

    .navbar-items {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .navbar-items li {
        display: inline-block;
        margin-right: 10px;
    }

    .navbar-items li a {
        text-decoration: none;
        color: #000;
        padding: 5px;
    }
    .disabled {
  background-color: #ccc;
  pointer-events: none;
}

</style>
</head>
<body>
<nav class="navbar">
    <ul class="navbar-items">
        <li><a href="../home.php">Home</a></li>
        <li><a href="in1.html">BACK</a></li>
      </ul>
</nav>




<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "wood";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:../login.php');
};
// Retrieve the last submitted form for the provided email


    // Retrieve the relevant data from the database based on the user's email
    $sql = "SELECT * FROM service_requests WHERE user_id = '$user_id' ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
        if($row['price']>0){


        echo '<h2>Last Submitted Form</h2>';
        echo '<table>';
        echo '<tr><th>orderID</th><th>USERID</th><th>Name</th><th>Email</th><th>Service</th><th>Height</th><th>Width</th><th>Wood</th><th>Price</th><th>Photo</th><th>Accept/decline</th></tr>';

        echo '<tr>';
        echo '<td>' . $row["id"] . '</td>';
        echo '<td>' . $row["user_id"] . '</td>';
        echo '<td>' . $row["name"] . '</td>';
        echo '<td>' . $row["email"] . '</td>';
        echo '<td>' . $row["service"] . '</td>';
        echo '<td>' . $row["height"] . '</td>';
        echo '<td>' . $row["width"] . '</td>';
        echo '<td>' . $row["wood"] . '</td>';
        echo '<td>' . $row["price"] . '</td>';
        echo '<td><img src="' . $row["photo"] . '" alt="Uploaded Photo" style="max-width: 100px;"></td>';
       
        echo '<form action="view_last_form.php" method="post">';
       echo '<td>';

    // Accept button
    $status = $row['status'];
echo '<input type="hidden" name="orderid" value="' . $row['id'] . '">';
echo '<input type="submit" name="accept" value="Accept" class="btn' . ($status === "Accepted" ? ' disabled' : '') . '" ' . ($status === "Accepted" ? 'disabled' : '') . '>';

    
    // Decline button
    echo '<input type="submit" name="decline" value="Decline" class="btn' . ($status === "Accepted" ? ' disabled' : '') . '" ' . ($status === "Accepted" ? 'disabled' : '') . '>';


    echo '</form>';
               
    echo '</td>';

        echo '</tr>';

        echo '</table>';
      }else{
        echo "waiting for an admin to assign price";
       }
      }
  } else {
      echo "No submitted forms found for the provided email.";
  }
        if (isset($_POST['accept'])) {
          // Accept button was clicked
          // Perform actions for accepting the request (e.g., update status in the database)
          $order_id=$_POST['orderid'];
          $sql = "UPDATE service_requests SET status = 'Accepted' WHERE id = '$order_id'";
          mysqli_query($conn, $sql);
    
          echo '<script>alert("Your Order is Accepted! and Shortly Delivered, Our Staff Will Contact You at the Time of Delivery. Thank You")</script>';
          header("Refresh: 1");
      } elseif (isset($_POST['decline'])) {
          // Decline button was clicked
          // Perform actions for declining the request (e.g., update status in the database)
          $order_id=$_POST['orderid'];
          $sql = "Delete from service_requests WHERE id = '$order_id'";
          mysqli_query($conn, $sql);
    
          echo '<script>alert("request for decline is successfull")</script>';
          header("Refresh: 1"); // Refreshes the page after 5 seconds

      }
    
         // Disable the buttons after they are clicked
         
         
    

?>
</body>
</html>