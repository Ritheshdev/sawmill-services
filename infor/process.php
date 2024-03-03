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

// Process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql1 = "SELECT * FROM `users` WHERE id='$user_id'";

    $result = mysqli_query($conn, $sql1);
    
        // Fetch data and store in variables
         $row = mysqli_fetch_assoc($result);
            
            $name = $row['name'];
            $email = $row['email'];
            $number = $row['number'];
    $service = $_POST["service"];
    $height = $_POST["height"];
    $width = $_POST["width"];
    $wood  = $_POST["wood"];

    // Upload photo
    $photoName = $_FILES["photo"]["name"];
    $photoTmpName = $_FILES["photo"]["tmp_name"];
    $photoError = $_FILES["photo"]["error"];

    // Create the "uploads" directory if it doesn't exist
    if (!is_dir("uploads")) {
        mkdir("uploads");
    }

    if ($photoError === 0) {
        $photoDestination = "uploads/" . $photoName;
        move_uploaded_file($photoTmpName, $photoDestination);
    }

    // Store the form data in the database
    $sql = "INSERT INTO service_requests (user_id,name, email,number, service, height, width,wood, photo)
                VALUES ('$user_id','$name', '$email','$number', '$service', '$height', '$width','$wood', '$photoDestination')";

    if (mysqli_query($conn, $sql)) {
        echo '<h2>Form submitted successfully.</h2><br>';

        echo '<div class="form-data"><label>Name:</label><span>' . $name . '</span></div>';
        echo '<div class="form-data"><label>Email:</label><span>' . $email . '</span></div>';
        echo '<div class="form-data"><label>Service:</label><span>' . $service . '</span></div>';
        echo '<div class="form-data"><label>Height:</label><span>' . $height . '</span></div>';
        echo '<div class="form-data"><label>Width:</label><span>' . $width . '</span></div>';
        echo '<div class="form-data"><label>Wood:</label><span>' . $wood . '</span></div>';
        echo '<div class="form-data">Uploaded Photo:<br><img class="uploaded-photo" src="' . $photoDestination . '" alt="Uploaded Photo"></div>';
        echo '<a class="navigation-link" href="in1.html">Go back to in1.html</a>';

    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
               body {
            background-color: #a9dce3;
            color: #333;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        h2 {
            color: green;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            padding-top: 20px; /* Add padding to create space between the heading and the form */
        }

        .form-data {
            margin-bottom: 10px;
            text-align: left;
        }

        .form-data label {
            font-weight: bold;
        }

        .form-data span {
            margin-left: 10px;
        }

        .uploaded-photo {
            max-width: 500px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Your HTML content here -->
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
