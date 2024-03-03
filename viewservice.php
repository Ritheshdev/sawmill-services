<?php
$mysqli = new mysqli('localhost', 'root', '', 'wood');
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if (isset($_GET['date'])) {
    $date = $_GET['date'];

    // Step 2: Execute a SELECT query
    $query = $mysqli->prepare("SELECT * FROM bookings WHERE date = ?");
    $query->bind_param('s', $date);
    $query->execute();

    // Step 3: Retrieve and store the results
    $result = $query->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Table Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 20px;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 12px;
        }
        
        th {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        tr:hover {
            background-color: #e2e2e2;
        }
        
        p {
            margin-top: 20px;
            font-style: italic;
            color: #555555;
        }
    </style>
</head>
<body>
    <?php if (isset($rows) && count($rows) > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date</th>
                <th>Time</th>
                <th>Resource ID</th>
                <th>Resource Name</th>
            </tr>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['timeslot']; ?></td>
                    <td><?php echo $row['resource_id']; ?></td>
                    <td><?php echo $row['resource_name']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No bookings found for the selected date.</p>
    <?php endif; ?>
</body>
</html>
