<?php
include 'db.php';

// Fetch notifications
$sql = "SELECT * FROM Notifications ORDER BY Date DESC";
$result = $conn->query($sql);

// Mark all notifications as read
$conn->query("UPDATE Notifications SET IsRead = TRUE WHERE IsRead = FALSE");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Notifications</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fdfbfb, #ebedee);
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .notification-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .notification {
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .notification h4 {
            margin: 0;
            font-size: 1.2rem;
        }

        .notification p {
            margin: 5px 0 0;
            color: #555;
        }

        .notification time {
            display: block;
            margin-top: 5px;
            font-size: 0.9rem;
            color: #888;
        }
    </style>
</head>
<body>
    <h2>Admin Notifications</h2>
    <div class="notification-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="notification">
                    <h4><?= htmlspecialchars($row['Title']) ?></h4>
                    <p><?= htmlspecialchars($row['Message']) ?></p>
                    <time><?= htmlspecialchars($row['Date']) ?></time>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No notifications at this time.</p>
        <?php endif; ?>
    </div>
</body>
</html>
