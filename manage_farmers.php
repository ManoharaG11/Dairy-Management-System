<?php
include 'db.php';

// Add Farmer
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO Farmers (Name, Address, Contact) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $address, $contact);
    if ($stmt->execute()) {
        echo "<div class='alert success'>Farmer added successfully!</div>";
    } else {
        echo "<div class='alert error'>Error: " . $stmt->error . "</div>";
    }
}

// Fetch Farmers
$sql = "SELECT * FROM Farmers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Management</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #34c0eb, #1e90ff);
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            color: #fff;
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
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 15px;
            text-align: center;
        }

        table th {
            background: linear-gradient(135deg, #34c0eb, #1e90ff);
            color: #fff;
            font-weight: bold;
        }

        table td {
            background-color: rgba(255, 255, 255, 0.1);
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
    <h2>Farmers List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['FarmerID'] ?></td>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['Address'] ?></td>
                <td><?= $row['Contact'] ?></td>
            </tr>
        <?php } ?>
    </table>

    <div class="form-container">
        <h3>Add New Farmer</h3>
        <form method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="address">Address:</label>
            <input type="text" name="address">

            <label for="contact">Contact:</label>
            <input type="text" name="contact" required>

            <button type="submit">Add Farmer</button>
        </form>
    </div>
</body>
</html>
