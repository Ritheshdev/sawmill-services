<!DOCTYPE html>
<html>
<head>
    <title>Service Request Form</title>
</head>
<body>
    <h1>Nirmala Saw Mill</h1>
    <?php
    // Database connection
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "wood";

    $conn = mysqli_connect($host, $username, $password, $database);
    
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
        $sql = "INSERT INTO service_requests (id,name, email,number, service, height, width, photo)
                VALUES ('$user_id','$name', '$email','$number', '$service', '$height', '$width', '$photoDestination')";

        if (mysqli_query($conn, $sql)) {
            echo "Form submitted successfully.<br>";
            echo "Name: " . $name . "<br>";
            echo "Email: " . $email . "<br>";
            echo "Service: " . $service . "<br>";
            echo "Height: " . $height . "<br>";
            echo "Width: " . $width . "<br>";
            echo 'Uploaded Photo: <br><img src="' . $photoDestination . '" alt="Uploaded Photo" style="max-width: 500px;"><br>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        

        <label for="service">Type of Service:</label>
        <select id="service" name="service" required>
            <option value="">Select Service</option>
            <option value="door">door</option>
            <option value="table">table</option>
            <option value="chair">chair</option>
        </select><br><br>

        <label for="height">Height:</label>
        <input type="text" id="height" name="height" required><br><br>

        <label for="width">Width:</label>
        <input type="text" id="width" name="width" required><br><br>
        <label for="photo">Upload Photo:</label>
        <input type="file" id="photo" name="photo" required><br><br>

        <input type="submit" value="Submit">

        <a href="view_forms.php?email=<?=$fet?>">View Submitted Forms</a>

    </form>
</body>
</html>

        

