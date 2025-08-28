<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactId = $_POST['contact_id'];

    $query = "UPDATE ContactUs SET Status = 'Viewed' WHERE ContactID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $contactId);

    if ($stmt->execute()) {
        header('Location: admin_notifications.php');
    } else {
        echo "Error updating message status.";
    }
}
?>
