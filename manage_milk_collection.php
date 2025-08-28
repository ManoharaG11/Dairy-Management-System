<?php
include 'db.php';

// Add Milk Collection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $farmerID = $_POST['farmer_id'];
    $quantity = $_POST['quantity'];
    $fatContent = $_POST['fat_content'];
    $rate = $_POST['rate'];

    $sql = "INSERT INTO MilkCollection (FarmerID, Date, Quantity, FatContent, Rate) VALUES (?, CURDATE(), ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iddd", $farmerID, $quantity, $fatContent, $rate);
    if ($stmt->execute()) {
        echo "Milk collection added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch Milk Collection Records
$sql = "SELECT MilkCollection.*, Farmers.Name AS FarmerName 
        FROM MilkCollection 
        JOIN Farmers ON MilkCollection.FarmerID = Farmers.FarmerID";
$result = $conn->query($sql);
?>

<h2>Milk Collection</h2>
<table border="1">
    <tr>
        <th>Collection ID</th>
        <th>Farmer</th>
        <th>Date</th>
        <th>Quantity (Liters)</th>
        <th>Fat Content (%)</th>
        <th>Rate (Per Liter)</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['CollectionID'] ?></td>
            <td><?= $row['FarmerName'] ?></td>
            <td><?= $row['Date'] ?></td>
            <td><?= $row['Quantity'] ?></td>
            <td><?= $row['FatContent'] ?></td>
            <td><?= $row['Rate'] ?></td>
        </tr>
    <?php } ?>
</table>

<h2>Add Milk Collection</h2>
<form method="post">
    <label>Farmer ID:</label>
    <input type="number" name="farmer_id" required>
    <label>Quantity (Liters):</label>
    <input type="number" step="0.01" name="quantity" required>
    <label>Fat Content (%):</label>
    <input type="number" step="0.01" name="fat_content" required>
    <label>Rate (Per Liter):</label>
    <input type="number" step="0.01" name="rate" required>
    <button type="submit">Add Collection</button>
</form>
