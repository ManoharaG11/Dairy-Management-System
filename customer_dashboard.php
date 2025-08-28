<?php
// Start the session to manage customer login state
session_start();

// Include database connection
include 'db.php';

// Check if customer is logged in, redirect to login if not
if (!isset($_SESSION['customer_email'])) {
    header('Location: customer_login.php');
    exit();
}

// Get the logged-in customer's email
$customer_email = $_SESSION['customer_email'];

// Query to fetch customer details
$query = "SELECT * FROM Customers WHERE Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $customer_email);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff6f61, #ff8a00);
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        nav a {
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #333;
            color: #fff;
            border-radius: 5px;
            font-size: 1rem;
            transition: background 0.3s ease-in-out;
        }

        nav a:hover {
            background-color: #ff8a00;
        }

        section {
            margin-top: 40px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        section h2 {
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            font-size: 1.1rem;
        }

        table th {
            background-color: #333;
            color: #fff;
        }

        table td {
            color: #eee;
        }

        table tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        table tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transition: background-color 0.3s ease;
        }

        .footer {
            margin-top: 40px;
            font-size: 0.9rem;
            color: #fff;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome, <?= htmlspecialchars($customer['Name']); ?>!</h1>
</header>

<nav>
    <a href="milk_products.php">View Products</a>
    <a href="view_cart.php">View Cart</a>
    <a href="checkout.php">Proceed to Checkout</a>
    <a href="orderhistory.php">Order History</a>
    <a href="logout.php">Logout</a>
</nav>

<section>
    <h2>My Profile</h2>
    <table>
        <tr>
            <th>Customer ID</th>
            <td><?= htmlspecialchars($customer['CustomerID']); ?></td>
        </tr>
        <tr>
            <th>Name</th>
            <td><?= htmlspecialchars($customer['Name']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($customer['Email']); ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?= htmlspecialchars($customer['Address']); ?></td>
        </tr>
        <tr>
            <th>Contact</th>
            <td><?= htmlspecialchars($customer['Contact']); ?></td>
        </tr>
    </table>
</section>

<footer class="footer">
    <p>&copy; 2025 Dairy Delight | All rights reserved.</p>
</footer>

</body>
</html>

<?php
$conn->close();
?>
