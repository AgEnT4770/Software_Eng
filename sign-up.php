<?php
include 'db.php'; // Include database connection
session_start(); // Start session for logged-in user handling

$error_message = ""; // Store error messages for duplicate users or other errors

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Securely hash the password
    $role = $_POST['user-type'];

    // Check if the username or email already exists
    $check_sql = "SELECT * FROM users WHERE name = ? OR email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $name, $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $error_message = "The email or username already exists. Please choose another.";
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO users (name, email, password, role, subscription) VALUES (?, ?, ?, ?, 'None')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $password, $role);

        if ($stmt->execute()) {
            // Initialize session for the newly registered user
            $_SESSION['username'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            // Redirect based on the role
            if ($role === "customer") {
                header("Location: customer.php");
            } elseif ($role === "merchant") {
                header("Location: merchant.html");
            } elseif ($role === "admin") {
                header("Location: admin.php");
            }
            exit();
        } else {
            $error_message = "An error occurred during signup. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Loyal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/sign-up.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="signup-container">
        <div class="signup-box">
            <h1 class="logo">Loyal</h1>
            <h2>Sign Up for an Account</h2>

            <!-- Display Error Message -->
            <?php if (!empty($error_message)) { ?>
                <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
            <?php } ?>

            <form method="POST">
                <div class="input-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="input-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="input-group">
                    <label for="user-type"><i class="fas fa-users"></i> User Type</label>
                    <select id="user-type" name="user-type" required>
                        <option value="" disabled selected>Select your user type</option>
                        <option value="customer">Customer</option>
                        <option value="merchant">Merchant</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="signup-btn">Sign Up</button>
            </form>

            <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>