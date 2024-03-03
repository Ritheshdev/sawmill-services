<!DOCTYPE html>
<html>
<head>
    <title>Wood Price Sheet</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        #total-amount {
            font-weight: bold;
            margin-top: 10px;
        }

        .delete-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <h1>Wood Price Sheet</h1>

    <?php
$conn = mysqli_connect('localhost', 'root', '', 'wood');

// Insert new wood data into the table
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $safety = $_POST['safety'];
    $totalSafety = $_POST['total_safety'];
    $totalPrice = $totalSafety * $price ;

    $query = "INSERT INTO wood_data (name, price, safety, total_safety, total_price) VALUES ('$name', '$price', '$safety', '$totalSafety', '$totalPrice')";
    mysqli_query($conn, $query);

    // Redirect to prevent form resubmission
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Delete wood data from the table
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM wood_data WHERE id = $id";
    mysqli_query($conn, $query);

    // Redirect to prevent form resubmission
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Fetch wood data from the table
$query = "SELECT * FROM wood_data";
$result = mysqli_query($conn, $query);
?>

<!-- Rest of the HTML code -->


    
    <table>
        <tr>
            <th>Name</th>
           
            <th>price per feet</th>
            <th>Total feet</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
          
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['total_safety']; ?></td>
            <td><?php echo $row['total_price']; ?></td>
            <td><a href="?delete=<?php echo $row['id']; ?>" class="delete-button">Delete</a></td>
        </tr>
        <?php } ?>
    </table>

    <?php
    // Calculate and display the total amount
    $query = "SELECT SUM(total_price) AS total_amount FROM wood_data";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $totalAmount = $row['total_amount'];
    ?>
    <div id="total-amount">Total Amount: <?php echo $totalAmount; ?></div>

    <h2>Add Wood Data</h2>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required><br>

        

        <label for="total_safety">Total feet:</label>
        <input type="number" step="0.01" id="total_safety" name="total_safety" required><br>

        <input type="submit" name="submit" value="Add Wood Data">
        <a href="admin_page.php">Back to home </a>
    </form>
    <style>form {
  margin-top: 20px;
}

label {
  display: inline-block;
  width: 120px;
  font-weight: bold;
}

input[type="text"],
input[type="number"] {
  padding: 5px;
  margin-bottom: 10px;
  width: 200px;
}

input[type="submit"] {
  padding: 5px 10px;
  background-color: #4CAF50;
  color: white;
  border: none;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #45a049;
}
</style>

    <?php mysqli_close($conn); ?>
</body>
</html>
