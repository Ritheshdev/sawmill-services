<?php
// Database connection details
include 'config.php';

// Fetch data from the products table
$query = $conn->prepare("SELECT * FROM products");
$query->execute();

// Print the table header
echo "<table>";
echo "<tr><th>Product ID</th><th>Image</th><th>Category</th><th>Product Name</th><th>Quantity</th></tr>";

// Iterate over the rows and print the data in a table format
while ($row =$query->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo '<td><img src="' . $row['image'] . '" alt="uploaded_img" style="max-width: 100px;"></td>';
    echo "<td>" . $row['category'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['quantity'] . "</td>";
    echo "</tr>";
}

// Close the result set and database connection


// Close the table
echo "</table>";
?>
?>
<!DOCTYPE html>
<html>
<head>
<style>
    table {
  width: 50%;
  border-collapse: collapse;
}

table th,
table td {
  padding: 8px;
  border: 1px solid #ccc;
}

table th {
  background-color: #5CB3FF;
  font-weight: bold;
}

table tr:nth-child(even) {
  background-color: #87CEEB;
}

table tr:hover {
  background-color: #87CEEB;
}

table img {
  max-width: 100px;
}


    .btn {
        background-color: darkgreen;
    }

    .navbar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        background-color: #f2f2f2;
        padding: 10px;
    }

    .navbar-items {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .navbar-items li {
        display: inline-block;
        margin-right: 10px;
    }

    .navbar-items li a {
        text-decoration: none;
        color: #000;
        padding: 5px;
    }
    .disabled {
  background-color: #ccc;
  pointer-events: none;
}

</style>
</head>
<body>
<nav class="navbar">
    <ul class="navbar-items">
        <li><a href="../admin_page.php">Home</a></li>
        
      </ul>
</nav>

</head>
</html>
