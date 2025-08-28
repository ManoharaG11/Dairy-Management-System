<?php
include 'db.php';
session_start();

if (!isset($_SESSION['customer_email']) || !isset($_SESSION['cart'])) {
    header("Location: milk_products.php");
    exit();
}

// Fetch customer ID
$customerEmail = $_SESSION['customer_email'];
$query = "SELECT CustomerID FROM Customers WHERE Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $customerEmail);
$stmt->execute();
$customer = $stmt->get_result()->fetch_assoc();
$customerId = $customer['CustomerID'];

// Fetch cart items
$cartItems = $_SESSION['cart'];
$totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff7f50, #ff6347);
            color: #fff;
            padding: 50px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
        }

        table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #fff;
            font-size: 1rem;
        }

        table th {
            background-color: #333;
        }

        td {
            color: #fff;
        }

        .total-row {
            font-weight: bold;
            background-color: #333;
            color: #ff6347;
        }

        .total-row td {
            font-size: 1.2rem;
        }

        button {
            background: linear-gradient(90deg, #ff7f50, #ff6347);
            color: #fff;
            padding: 12px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s, transform 0.2s;
            margin-top: 20px;
        }

        button:hover {
            background: linear-gradient(90deg, #ff6347, #ff7f50);
            transform: scale(1.05);
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 1rem;
            color: #ff7f50;
            text-decoration: none;
            transition: color 0.3s;
        }

        a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>Checkout</h1>
    <form method="POST" action="place_order.php">
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $productId => $quantity) : 
                    // Fetch product details
                    $query = "SELECT ProductName, Price FROM MilkProducts WHERE ProductID = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $productId);
                    $stmt->execute();
                    $product = $stmt->get_result()->fetch_assoc();
                    $productName = $product['ProductName'];
                    $price = $product['Price'];
                    $subtotal = $price * $quantity;
                    $totalPrice += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($productName); ?></td>
                        <td><?= number_format($price, 2); ?></td>
                        <td><?= $quantity; ?></td>
                        <td><?= number_format($subtotal, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="3">Total</td>
                    <td><?= number_format($totalPrice, 2); ?></td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="total" value="<?= $totalPrice; ?>">
        <button type="submit">Place Order</button>
    </form>
    <a href="milk_products.php">Continue Shopping</a>
</body>
</html>
