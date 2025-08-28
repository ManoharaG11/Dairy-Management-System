<?php
include 'db.php';
session_start();

if (!isset($_SESSION['customer_email'])) {
    header("Location: customer_login.php");
    exit();
}

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch milk products from the database
$query = "SELECT * FROM MilkProducts WHERE Stock > 0";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    die("No products available or query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Products</title>
</head>
<body>
    <h1>Available Milk Products</h1>
    <form method="POST" action="add_to_cart.php">
        <table border="1">
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Quantity</th>
                <th>Add to Cart</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['ProductName']); ?></td>
                    <td><?= htmlspecialchars($row['Price']); ?></td>
                    <td><?= htmlspecialchars($row['Stock']); ?></td>
                    <td><input type="number" name="quantity[<?= $row['ProductID']; ?>]" min="1" max="<?= $row['Stock']; ?>"></td>
                    <td><input type="checkbox" name="products[]" value="<?= $row['ProductID']; ?>"></td>
                </tr>
            <?php } ?>
        </table>
        <button type="submit">Add to Cart</button>
    </form>
</body>
</html>