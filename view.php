<?php
    $mysqli = new mysqli('localhost', 'root', '', 'wood');
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }
    session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};
$stmt=$mysqli->prepare("SELECT * from `bookings` WHERE id=?");
$stmt->bind_param('i',$user_id);
$stmt->execute();
$result=$stmt->get_result();
$rows = $result->fetch_all(MYSQLI_ASSOC);
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
        .btn-delete{
            background-color: red;


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
    </style>
</head>
<body>
<nav class="navbar">
    <ul class="navbar-items">
        <li><a href="home.php">Home</a></li>
        <li><a href="calendar.php">BACK</a></li>
      </ul>
</nav>
   
    <?php if (isset($rows) && count($rows) > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date</th>
                <th>Time</th>
                <th>Resource ID</th>
                <th>resource name</th>
                
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
                    <td>
                    <form method="get" action="delete.php">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="resource_id" value="<?php echo $row['resource_id']; ?>">
                            <input type="hidden" name="date" value="<?php echo $row['date']; ?>">
                            <input type="hidden" name="slot" value="<?php echo $row['timeslot']; ?>">
                            <button class='btn-delete' type="submit">Cancel</button>
                        </form>
            </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No bookings found</p>
    <?php endif; ?>
    
    <a href='index.php'>Back</a>
  
    
</body>
</html>
