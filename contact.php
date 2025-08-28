<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    // Save contact form submission
    $sql = "INSERT INTO ContactMessages (Name, Email, Message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);
    if ($stmt->execute()) {
        // Add a notification for the admin
        $notificationTitle = "New Contact Form Submission";
        $notificationMessage = "You have a new message from $name.";
        $notifySQL = "INSERT INTO Notifications (Title, Message) VALUES (?, ?)";
        $notifyStmt = $conn->prepare($notifySQL);
        $notifyStmt->bind_param("ss", $notificationTitle, $notificationMessage);
        $notifyStmt->execute();

        echo "<div class='alert success'>Message sent successfully!</div>";
    } else {
        echo "<div class='alert error'>Error: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
</head>
<body>
    <h2>Contact Us</h2>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="message">Message:</label>
        <textarea name="message" required></textarea>
        <button type="submit">Send</button>
    </form>
</body>
</html>
