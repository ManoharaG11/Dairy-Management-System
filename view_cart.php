<?php
include 'db.php';
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty. <a href='milk_products.php'>Shop now</a>";
    exit();
}

$productIds = implode(',', array_keys($_SESSION['cart']));
$query = "SELECT * FROM MilkProducts WHERE ProductID IN ($productIds)";
$result = $conn->query($query);
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f4f8, #d0e2e6);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            font-size: 2.5rem;
            text-align: center;
            color: #333;
            margin-bottom: 2rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1200px;
            animation: fadeIn 1s ease-in-out;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        table th, table td {
            padding: 1rem;
            text-align: center;
            font-size: 1rem;
            color: #333;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table input[type="number"], table input[type="checkbox"] {
            margin: 0.5rem;
            padding: 0.5rem;
            border-radius: 10px;
            border: 1px solid #ddd;
            background: #f1f1f1;
            transition: all 0.3s ease;
        }

        table input[type="number"]:focus, table input[type="checkbox"]:focus {
            border-color: #4CAF50;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .total {
            font-size: 1.2rem;
            margin-top: 1rem;
            text-align: right;
            font-weight: bold;
            color: #333;
        }

        button {
            padding: 0.8rem 2rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin: 0 auto;
        }

        button:hover {
            background-color: #45a049;
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
    <h1>Your Cart</h1>
    <div class="container">
        <form method="POST" action="checkout.php">
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>SubTotal</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { 
                    $productId = $row['ProductID'];
                    $quantity = $_SESSION['cart'][$productId];
                    $subtotal = $row['Price'] * $quantity;
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ProductName']) ?></td>
                        <td>$<?= number_format($row['Price'], 2) ?></td>
                        <td><?= $quantity ?></td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                    </tr>
                <?php } ?>
            </table>
            <div class="total">Total: $<?= number_format($total, 2) ?></div>
            <input type="hidden" name="total" value="<?= $total ?>">
            <button type="submit">Proceed to Checkout</button>
        </form>
    </div>
</body>
</html>
