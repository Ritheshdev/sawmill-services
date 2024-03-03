<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the relevant data from the database based on the given ID
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "wood";

    $conn = mysqli_connect($host, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $id = mysqli_real_escape_string($conn, $id); // Escape the ID to prevent SQL injection

    $sql = "SELECT message FROM service_requests WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $message = $row['message'];

        // Display the received message
        echo '<h2>Received Message</h2>';
        echo '<p>' . $message . '</p>';
    } else {
        echo "No record found for the provided ID.";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
