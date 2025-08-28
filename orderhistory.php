<?php
include 'db.php';
session_start();

if (!isset($_SESSION['customer_id'])) {
    echo "You must log in to view your order history.";
    exit;
}

$customerId = $_SESSION['customer_id'];

$query = "SELECT o.OrderID, o.TotalAmount, o.OrderDate, 
            GROUP_CONCAT(p.ProductName SEPARATOR ', ') AS Products 
          FROM Orders o
          JOIN OrderDetails od ON o.OrderID = od.OrderID
          JOIN MilkProducts p ON od.ProductID = p.ProductID
          WHERE o.CustomerID = ? 
          GROUP BY o.OrderID";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        h1 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            animation: fadeIn 1s ease-in-out;
        }

        th, td {
            padding: 15px;
            text-align: center;
            font-size: 1rem;
            color: #333;
        }

        th {
            background-color: #ff6a88;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        td {
            border-bottom: 1px solid #ddd;
        }

        .order-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff6a88;
            color: white;
            border-radius: 20px;
            text-decoration: none;
            margin-top: 1rem;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .order-btn:hover {
            background-color: #ff5177;
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

    <div>
        <h1>Your Order History</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Products</th>
                    <th>Total Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['OrderID']; ?></td>
                        <td><?= $row['OrderDate']; ?></td>
                        <td><?= $row['Products']; ?></td>
                        <td>₹<?= number_format($row['TotalAmount'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="milk_products.php" class="order-btn">Shop More</a>
    </div>

</body>
</html>
