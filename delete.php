<?php
    $mysqli = new mysqli('localhost', 'root', '', 'service');
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }
    session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};
if(isset($_GET['delete_id'])){
        $delete_id = $_GET['delete_id'];
        $resource_id = $_GET['resource_id'];
        $date = $_GET['date'];
        $slot=$_GET['slot'];
        $currentdate = date('Y-m-d');
    
        $date_diff = date_diff(date_create($currentdate), date_create($date));
        $days_diff = $date_diff->format("%a");
    
        if ($days_diff <= 1) {
            echo "<script>alert('Cannot cancel.');</script>";
            header('Location: view.php');
            exit();
        }


        // Prepare and execute the delete statement
        $delete_stmt = $mysqli->prepare("DELETE FROM `bookings` WHERE id = ? AND date = ? AND resource_id = ? AND timeslot=?");
        $delete_stmt->bind_param('isis', $delete_id,$date,$resource_id,$slot);
        $delete_stmt->execute();

        // Redirect to the same page to update the table
        header('Location: view.php');
        exit();
    }
