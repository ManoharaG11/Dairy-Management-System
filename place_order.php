<?php
session_start();
include 'db.php'; // Database connection file

// Ensure the user is logged in
if (!isset($_SESSION['customer_email']) || !isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    echo "Your cart is empty! <a href='milk_products.php'>Shop Now</a>";
    exit();
}

// Retrieve customer ID and initialize total
$customerId = $_SESSION['customer_id'];
$totalAmount = 0;

// Calculate the total amount from the cart
foreach ($_SESSION['cart'] as $productId => $quantity) {
    $query = "SELECT Price FROM MilkProducts WHERE ProductID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $totalAmount += $product['Price'] * $quantity;
    } else {
        echo "Error: Product ID $productId not found.";
        exit();
    }
}

// Insert the order into the Orders table
$orderQuery = "INSERT INTO Orders (CustomerID, TotalAmount) VALUES (?, ?)";
$stmt = $conn->prepare($orderQuery);
$stmt->bind_param("id", $customerId, $totalAmount);
if (!$stmt->execute()) {
    die("Error inserting order: " . $stmt->error);
}
$orderId = $stmt->insert_id; // Get the last inserted OrderID

// Insert order details and update stock
foreach ($_SESSION['cart'] as $productId => $quantity) {
    // Insert into OrderDetails
    $detailsQuery = "INSERT INTO OrderDetails (OrderID, ProductID, Quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($detailsQuery);
    $stmt->bind_param("iii", $orderId, $productId, $quantity);
    if (!$stmt->execute()) {
        die("Error inserting order details: " . $stmt->error);
    }

    // Update stock
    $updateStockQuery = "UPDATE MilkProducts SET Stock = Stock - ? WHERE ProductID = ?";
    $stmt = $conn->prepare($updateStockQuery);
    $stmt->bind_param("ii", $quantity, $productId);
    if (!$stmt->execute()) {
        die("Error updating stock: " . $stmt->error);
    }
}

// Clear the cart after placing the order
unset($_SESSION['cart']);

// Order confirmation
echo "Order placed successfully! Your Order ID is: $orderId";
echo "<br><a href='milk_products.php'>Shop Again</a>";
?>
