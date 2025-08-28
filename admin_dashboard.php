<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e90ff, #87ceeb);
            color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dashboard-container {
            background: rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 600px;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 1.5s ease-in-out;
        }

        .dashboard-container h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .dashboard-container a {
            display: block;
            background: linear-gradient(90deg, #1e90ff, #4682b4);
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            padding: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .dashboard-container a:hover {
            background: linear-gradient(90deg, #4682b4, #1e90ff);
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .logout-btn {
            background: #ff6a88;
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: #ff3d56;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION['admin']; ?></h2>

        <a href="manage_farmers.php">Manage Farmers</a>
        <a href="manage_milk_products.php">Manage Milk Products</a>
        <a href="manage_sales.php">Manage Sales</a>
        <a href="manage_payments.php">Manage Payments</a>
        <a href="view_sales.php">View sales</a>
        <a href="notifications.php">Notifications</a>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
