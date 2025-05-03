<?php
session_start(); // Start the session
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['user-type'];

    // Fetch user from database
    $sql = "SELECT * FROM users WHERE name = ? AND role = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['username'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($role === "customer") {
                header("Location: customer.php");
            } elseif ($role === "merchant") {
                header("Location: merchant.html");
            } elseif ($role === "admin") {
                header("Location: admin.php");
            }
            exit();
        } else {
            // Invalid password
            $error_message = "Invalid username or password.";
        }
    } else {
        // User not found
        $error_message = "Invalid username or password.";
    }

    // Redirect back to login with error message
    header("Location: login.php?error=" . urlencode($error_message));
    exit();
}
?>