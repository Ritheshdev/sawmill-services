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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        // Check which button was clicked
        if (isset($_POST['accept'])) {
            // Accept button was clicked
            // Perform actions for accepting the request (e.g., update status in the database)
            $sql = "UPDATE service_requests SET status = 'Accepted' WHERE id = '$user_id'";
            mysqli_query($conn, $sql);

            echo '<script>alert("Your Order is Accepted! and Shortly Delivered, Our Staff Will Contact You at the Time of Delivery. Thank You")</script>';
        } elseif (isset($_POST['decline'])) {
            // Decline button was clicked
            // Perform actions for declining the request (e.g., update status in the database)
            $sql = "UPDATE service_requests SET status = 'Declined' WHERE id = '$user_id'";
            mysqli_query($conn, $sql);

            echo "Request for Order declined!";
        }
        
        // Disable the buttons
        // Disable the buttons after they are clicked
        echo '<script>';
        echo 'document.getElementById("accept").addEventListener("click", function(event) {';
        echo 'event.preventDefault();'; // Prevent form submission
        echo 'alert("Your Order is Accepted! and Shortly Delivered, Our Staff Will Contact You at the Time of Delivery. Thank You")';
        echo 'document.getElementById("accept").disabled = true;';
        echo 'document.getElementById("decline").disabled = true;';
        echo '});';

        echo 'document.getElementById("decline").addEventListener("click", function(event) {';
        echo 'event.preventDefault();'; // Prevent form submission
        echo 'document.getElementById("message").innerHTML = "Request for Order declined!";';
        echo 'document.getElementById("accept").disabled = true;';
        echo 'document.getElementById("decline").disabled = true;';
        echo '});';
        echo '</script>';

    } else {
        echo "Invalid action.";
    }

// Close the database connection
mysqli_close($conn);
?>
