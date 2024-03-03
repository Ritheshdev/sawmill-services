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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $price = $_POST["price"];

    // Update the price in the database for the specified ID
    $sql = "UPDATE service_requests SET price = '$price' WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "Price assigned successfully.";
    } else {
        echo "Error updating price: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
