<?php
// Start session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dairy Delight - Full Page</title>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(120deg, #f7f7f7, #ffffff);
            display: flex;
            flex-direction: column;
        }

        /* Header Section */
        header {
            background: linear-gradient(90deg, #ff9a8b, #ff6a88, #ff99ac);
            color: white;
            text-align: center;
            padding: 2rem 1rem;
            flex-shrink: 0;
        }

        header h1 {
            font-size: 4rem;
            letter-spacing: 3px;
        }

        header p {
            font-size: 1.5rem;
            margin-top: 1rem;
            font-style: italic;
        }

        /* Navigation Bar */
        nav {
            background: #ff6a88;
            display: flex;
            justify-content: center;
            gap: 2rem;
            padding: 1rem 0;
            flex-shrink: 0;
        }

        nav a {
            text-decoration: none;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: 0.3s;
        }

        nav a:hover {
            background: white;
            color: #ff6a88;
            box-shadow: 0px 4px 10px rgba(255, 105, 135, 0.3);
        }

        /* Main Content */
        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        main h2 {
            font-size: 3rem;
            color: #ff6a88;
            margin-bottom: 1rem;
        }

        main p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        main table {
            width: 80%;
            margin: 1rem auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        main th, main td {
            padding: 1.5rem;
            text-align: center;
            border: 1px solid #ddd;
        }

        main th {
            background: #ff6a88;
            color: white;
            text-transform: uppercase;
        }

        main td {
            font-size: 1.2rem;
        }

        button {
            padding: 0.8rem 1.5rem;
            background: #ff6a88;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        button:hover {
            background: #ff99ac;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(255, 105, 135, 0.2);
        }

        /* Footer */
        footer {
            background: linear-gradient(90deg, #ff9a8b, #ff6a88, #ff99ac);
            text-align: center;
            color: white;
            padding: 1rem 0;
            flex-shrink: 0;
        }

        footer p {
            font-size: 1rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dairy Delight</h1>
        <p>Your World of Creamy Wonders</p>
    </header>

    <nav>
        <a href="admin_login.php">Admin Login</a>
        <a href="customer_register.php">Register</a>
        <a href="customer_login.php">Customer Login</a>
        <a href="about.php">About</a>
       
    </nav>

    <main>
        <?php if (isset($_SESSION['admin'])): ?>
            <h2>Welcome, Admin!</h2>
            <p>Manage Dairy Delight with ease:</p>
            <table>
                <tr><th>Action</th></tr>
                <tr><td><a href="manage_farmers.php">Manage Farmers</a></td></tr>
                <tr><td><a href="manage_milk_products.php">Manage Milk Products</a></td></tr>
                <tr><td><a href="manage_sales.php">Manage Sales</a></td></tr>
                <tr><td><a href="logout.php">Logout</a></td></tr>
            </table>
        <?php elseif (isset($_SESSION['customer_email'])): ?>
            <h2>Welcome, <?= htmlspecialchars($_SESSION['customer_email']); ?>!</h2>
            <p>Explore and enjoy the goodness:</p>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Price (₹)</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
                <?php
                include 'db.php';
                $query = "SELECT * FROM MilkProducts";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['ProductName']) . "</td>";
                        echo "<td>" . $row['Price'] . "</td>";
                        echo "<td>" . $row['Stock'] . "</td>";
                        echo "<td>
                            <form action='add_to_cart.php' method='POST'>
                                <input type='hidden' name='product_id' value='{$row['ProductID']}'>
                                <button>Add to Cart</button>
                            </form>
                          </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No products available</td></tr>";
                }
                ?>
            </table>
        <?php else: ?>
            <h2>Welcome to Dairy Delight!</h2>
            <p>Join us to explore the best dairy products in town!</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?= date("Y"); ?> Dairy Delight. All Rights Reserved.</p>
    </footer>
</body>
</html>
