<?php
include 'db.php'; // Database connection

$user_id = $_GET['id']; // Get user ID from query string

// Delete user
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    header("Location: manage-clients-merchants.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>