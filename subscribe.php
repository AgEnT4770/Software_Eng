<?php
session_start(); // Start session at the top
include 'db.php'; // Include database connection

// Ensure the customer is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('You must log in to subscribe!'); window.location.href = 'login.php';</script>";
    exit();
}

// Fetch the logged-in customer's username
$username = $_SESSION['username'];

// Get the selected tier from the form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tier'])) {
    $tier = $_POST['tier'];

    // Update the subscription in the database
    $sql = "UPDATE users SET subscription = ? WHERE name = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ss", $tier, $username);

    if ($stmt->execute()) {
        // Success: Redirect back to dashboard
        echo "<script>alert('Subscribed to $tier successfully!'); window.location.href = 'customer.php';</script>";
    } else {
        // Error: Provide feedback
        echo "<script>alert('Error subscribing. Please try again later.'); window.location.href = 'customer.php';</script>";
    }
} else {
    echo "<script>alert('No subscription tier selected!'); window.location.href = 'customer.php';</script>";
}
?>