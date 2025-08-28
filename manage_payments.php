<?php
include 'db.php';

// Add Payment
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $farmerID = $_POST['farmer_id'];
    $amount = $_POST['amount'];

    $sql = "INSERT INTO Payments (FarmerID, Amount, Date) VALUES (?, ?, CURDATE())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $farmerID, $amount);
    if ($stmt->execute()) {
        echo "<div class='alert success'>Payment recorded successfully!</div>";
    } else {
        echo "<div class='alert error'>Error: " . $stmt->error . "</div>";
    }
}

// Fetch Payments
$sql = "SELECT Payments.*, Farmers.Name AS FarmerName 
        FROM Payments 
        JOIN Farmers ON Payments.FarmerID = Farmers.FarmerID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f4f4f7,rgb(0, 0, 0));
            height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h2 {
            text-align: center;
            margin: 20px;
            font-size: 2rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        table {
            width: 80%;
            margin-bottom: 50px;
            border-collapse: collapse;
            border-radius: 15px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
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
            background: rgba(255, 255, 255, 0.2);
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
            margin-bottom: 8px;
            font-size: 1rem;
            color: #fff;
        }

        .form-container input {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1.5rem;
            border-radius: 10px;
            border: none;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 1rem;
            outline: none;
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
            width: 80%;
            max-width: 500px;
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
    <h2>Payments List</h2>
    <table>
        <tr>
            <th>Payment ID</th>
            <th>Farmer</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['PaymentID'] ?></td>
                <td><?= $row['FarmerName'] ?></td>
                <td><?= $row['Amount'] ?></td>
                <td><?= $row['Date'] ?></td>
            </tr>
        <?php } ?>
    </table>

    <div class="form-container">
        <h3>Record Payment</h3>
        <form method="post">
            <label for="farmer_id">Farmer ID:</label>
            <input type="number" name="farmer_id" required>

            <label for="amount">Amount:</label>
            <input type="number" step="0.01" name="amount" required>

            <button type="submit">Record Payment</button>
        </form>
    </div>
</body>
</html>
