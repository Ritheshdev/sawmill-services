<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data
    $id = $_POST["id"];
    $message = $_POST["message"];

    // Insert the message into the database
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "wood";

    $conn = mysqli_connect($host, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE service_requests SET message = '$message' WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Message sent successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
