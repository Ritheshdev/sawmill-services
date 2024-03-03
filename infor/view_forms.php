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

// Retrieve the user's submitted forms
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Retrieve the relevant data from the database based on the user's email
    $sql = "SELECT * FROM service_requests WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<h2>Your Submitted Forms</h2>';
        echo '<table>';
        echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Service</th><th>Height</th><th>Width</th><th>Wood</th><th>Photo</th></tr>';

        // Display each submitted form
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row["id"] . '</td>';
            echo '<td>' . $row["name"] . '</td>';
            echo '<td>' . $row["email"] . '</td>';
            echo '<td>' . $row["service"] . '</td>';
            echo '<td>' . $row["height"] . '</td>';
            echo '<td>' . $row["width"] . '</td>';
            echo '<td>' . $row["wood"] . '</td>';
            echo '<td><img src="' . $row["photo"] . '" alt="Uploaded Photo" style="max-width: 100px;"></td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "No submitted forms found.";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($conn);
?>
