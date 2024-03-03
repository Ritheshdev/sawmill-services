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

    $sql = "SELECT * FROM service_requests WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Display the relevant data and provide a message input form
        echo '<h2>Send Message</h2>';
        echo '<form action="send_message.php" method="post">';
        echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
        echo 'Name: ' . $row["name"] . '<br>';
        echo 'Email: ' . $row["email"] . '<br>';
        echo 'Service: ' . $row["service"] . '<br>';
        echo 'Height: ' . $row["height"] . '<br>';
        echo 'Width: ' . $row["width"] . '<br>';
        echo 'Message: <textarea name="message" rows="4" cols="50"></textarea><br>';
        echo '<input type="submit" value="Send">';
        echo '</form>';
    } else {
        echo "No record found for the provided ID.";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
