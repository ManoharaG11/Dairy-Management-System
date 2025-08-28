<?php
include 'db.php';

// Add Product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO MilkProducts (Name, UnitPrice, Stock) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdd", $name, $price, $stock);
    if ($stmt->execute()) {
        echo "<div class='alert success'>Product added successfully!</div>";
    } else {
        echo "<div class='alert error'>Error: " . $stmt->error . "</div>";
    }
}

// Fetch Products
$sql = "SELECT * FROM MilkProducts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Products</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg,rgb(5, 6, 8),rgb(204, 74, 74));
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin: 30px 0;
            font-size: 2rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-bottom: 50px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 15px;
            text-align: center;
        }

        table th {
            background: linear-gradient(135deg, #1e90ff, #34c0eb);
            color: #fff;
            font-weight: bold;
        }

        table td {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 15px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease-in-out;
        }

        .form-container label {
            display: block;
            font-size: 1rem;
            margin: 10px 0 5px;
        }

        .form-container input {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1.5rem;
            border-radius: 10px;
            border: none;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            outline: none;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
        }

        .form-container input:focus {
            background: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
        }

        .form-container button {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 10px;
            background: linear-gradient(90deg, #34c0eb, #1e90ff);
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-container button:hover {
            background: linear-gradient(90deg, #1e90ff, #34c0eb);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .alert {
            padding: 1rem;
            text-align: center;
            margin: 20px;
            border-radius: 10px;
        }

        .alert.success {
            background-color: #28a745;
            color: #fff;
        }

        .alert.error {
            background-color: #dc3545;
            color: #fff;
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
    <h2>Milk Products List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Unit Price</th>
            <th>Stock</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['ProductID'] ?></td>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['UnitPrice'] ?></td>
                <td><?= $row['Stock'] ?></td>
            </tr>
        <?php } ?>
    </table>

    <div class="form-container">
        <h3>Add New Milk Product</h3>
        <form method="post">
            <label for="name">Product Name:</label>
            <input type="text" name="name" required>

            <label for="price">Unit Price ($):</label>
            <input type="number" step="0.01" name="price" required>

            <label for="stock">Stock Quantity:</label>
            <input type="number" step="1" name="stock" required>

            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>
