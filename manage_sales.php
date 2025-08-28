<?php
include 'db.php';

// Record Sale
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerID = intval($_POST['customer_id']);
    $productID = intval($_POST['product_id']);
    $quantity = floatval($_POST['quantity']);

    try {
        // Validate Inputs
        if ($customerID <= 0 || $productID <= 0 || $quantity <= 0) {
            throw new Exception("Invalid input values. Please provide valid data.");
        }

        // Check if Customer Exists
        $customerCheck = $conn->prepare("SELECT 1 FROM Customers WHERE CustomerID = ?");
        $customerCheck->bind_param("i", $customerID);
        $customerCheck->execute();
        $customerResult = $customerCheck->get_result();
        if ($customerResult->num_rows === 0) {
            throw new Exception("Customer ID does not exist. Please add the customer first.");
        }

        // Check if Product Exists
        $productCheck = $conn->prepare("SELECT UnitPrice FROM MilkProducts WHERE ProductID = ?");
        $productCheck->bind_param("i", $productID);
        $productCheck->execute();
        $productResult = $productCheck->get_result();
        if ($productResult->num_rows === 0) {
            throw new Exception("Product ID does not exist.");
        }

        $product = $productResult->fetch_assoc();
        $unitPrice = $product['UnitPrice'];

        // Calculate Total Price
        $totalPrice = $unitPrice * $quantity;

        // Insert Sale
        $sql = "INSERT INTO Sales (CustomerID, ProductID, Date, Quantity, TotalPrice) VALUES (?, ?, CURDATE(), ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iidd", $customerID, $productID, $quantity, $totalPrice);
        if ($stmt->execute()) {
            $successMessage = "Sale recorded successfully!";
        } else {
            throw new Exception("Database error: " . $stmt->error);
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

// Fetch Customers
$customers = $conn->query("SELECT CustomerID,Name FROM Customers");

// Fetch Products
$products = $conn->query("SELECT ProductID, ProductName FROM MilkProducts");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sales</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #74ebd5, #9face6);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            animation: fadeIn 0.5s ease-in-out;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
        }

        select, input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #4caf50;
            color: white;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #45a049;
        }

        .alert {
            padding: 1rem;
            margin-top: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .alert.success {
            background: #4caf50;
            color: white;
        }

        .alert.error {
            background: #f44336;
            color: white;
        }

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
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Sales</h2>

        <?php if (isset($successMessage)): ?>
            <div class="alert success"><?= htmlspecialchars($successMessage) ?></div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="alert error"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="customer_id">Customer</label>
                <select name="customer_id" required>
                    <option value="">Select Customer</option>
                    <?php while ($row = $customers->fetch_assoc()): ?>
                        <option value="<?= $row['CustomerID'] ?>"><?= htmlspecialchars($row['Name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="product_id">Product</label>
                <select name="product_id" required>
                    <option value="">Select Product</option>
                    <?php while ($row = $products->fetch_assoc()): ?>
                        <option value="<?= $row['ProductID'] ?>"><?= htmlspecialchars($row['ProductName']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" step="0.01" min="0" required>
            </div>

            <button type="submit">Record Sale</button>
        </form>
    </div>
</body>
</html>
