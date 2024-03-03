<?php


// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed Successfully</title>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        .container h1 {
            font-size: 24px;
            color: #2ecc71;
            margin-bottom: 10px;
        }

        .container p {
            font-size: 16px;
            color: #333;
        }

        .container img {
            margin-top: 20px;
            max-width: 100%;
        }
        .container button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #008000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Order Placed Successfully!</h1>
        <p>Thank you for your purchase.</p>
        <img src="success.png" alt="Order Placed Successfully">
        <button onclick="redirectToInvoice()">Okay</button>
    </div>

    <script>
        function redirectToInvoice() {
            window.location.href = "inv.php";
        }
    </script>
</body>
</html>
