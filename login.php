<?php
include 'db.php'; // Ensure this connects to your database

$error_message = ""; // Store error message for incorrect logins

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['user-type'];

    // Fetch user from database
    $sql = "SELECT * FROM users WHERE name = ? AND role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Start session and redirect based on role
            session_start();
            $_SESSION['username'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            if ($role === "customer") {
                header("Location: customer.php");
            } elseif ($role === "merchant") {
                header("Location: merchant.html");
            } elseif ($role === "admin") {
                header("Location: admin.php");
            }
            exit();
        } else {
            $error_message = "Username or password is incorrect.";
        }
    } else {
        $error_message = "Username or password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Loyal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1 class="logo">Loyal</h1>
            <h2>Login to Your Account</h2>

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
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="input-group">
                <label for="user-type"><i class="fas fa-users"></i> User Type</label>
                <select id="user-type" name="user-type" required>
                        <option value="customer">Customer</option>
                        <option value="merchant">Merchant</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>

            <p class="signup-link">Don't have an account? <a href="sign-up.php">Sign Up</a></p>
        </div>
    </div>
</body>
</html>