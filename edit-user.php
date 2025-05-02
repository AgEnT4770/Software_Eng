<?php
include 'db.php'; // Database connection

$error_message = "";
$success_message = "";
$user_id = $_GET['id']; // Get user ID from query string

// Fetch user details
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Update user details
    $update_sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $name, $email, $user_id);

    if ($update_stmt->execute()) {
        $success_message = "User updated successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="css/mange_cust&mach.css">
</head>
<body>
    <h1>Edit User</h1>
    <?php if (!empty($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
    <?php if (!empty($success_message)) { echo "<p class='success'>$success_message</p>"; } ?>

    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        
        <button type="submit">Update User</button>
    </form>
</body>
</html>