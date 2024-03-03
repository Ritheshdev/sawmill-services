<?php

@include 'config.php';

session_start();

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:admin_contacts.php');
}

$selectedSort = isset($_GET['sort']) ? $_GET['sort'] : 'all'; // Get the selected sort option

$query = "SELECT * FROM `message`";

// Modify the query based on the selected sort option
if ($selectedSort !== 'all') {
   $query .= " WHERE rating = ?";
}

$select_message = $conn->prepare($query);

// Bind the parameter value to the prepared statement if it's not "all"
if ($selectedSort !== 'all') {
   $select_message->bindParam(1, $selectedSort);
}

$select_message->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/admin_style.css"> 
  
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="messages">
   <h1 class="title">Feedback</h1>
   <div class="rating-filter">
      <form action="admin_contacts.php" method="get">
         <button type="submit" name="sort" value="all">All</button>
         <button type="submit" name="sort" value="good">Good</button>
         <button type="submit" name="sort" value="average">Average</button>
         <button type="submit" name="sort" value="bad">Bad</button>
      </form>
   </div>
   <style>
      .rating-filter {
  display: flex;
  justify-content: center;
}
   .rating-filter button {
  padding: 10px 20px;
  margin-right: 10px;
  font-size: 16px;
  background-color: #f0f0f0;
  justify-items: center;
  border: none;
  cursor: pointer;
}

.rating-filter button:hover {
  background-color: #e0e0e0;
}

.rating-filter button:focus {
  outline: none;
}

.rating-filter button[value="all"] {
  background-color: #4caf50;
  color: #fff;
}

.rating-filter button[value="good"] {
  background-color: #2196f3;
  color: #fff;
}

.rating-filter button[value="average"] {
  background-color: #ff9800;
  color: #fff;
}

.rating-filter button[value="bad"] {
  background-color: #f44336;
  color: #fff;
}
</style>

   <div class="box-container">
   <?php
      if($select_message->rowCount() > 0){
         while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){
   ?>
      <div class="box">
         <p>user id: <span><?= $fetch_message['user_id']; ?></span></p>
         <p>name: <span><?= $fetch_message['name']; ?></span></p>
         <p>number: <span><?= $fetch_message['number']; ?></span></p>
         <p>email: <span><?= $fetch_message['email']; ?></span></p>
         <p>rating: <span><?= $fetch_message['rating']; ?></span></p>
         <p>message: <span><?= $fetch_message['message']; ?></span></p>
         <a href="admin_contacts.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('Delete this message?');" class="delete-btn">Delete</a>
      </div>
   <?php
         }
      } else {
         echo '<p class="empty">You have no Feedback!</p>';
      }
   ?>
   </div>
</section>

<script src="js/script.js"></script>

</body>
</html>