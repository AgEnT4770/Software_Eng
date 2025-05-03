<?php
include '../db.php'; // Include database connection
session_start();

// Ensure admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

// Fetch client data from the database
$sql = "SELECT name, email, subscription FROM users WHERE role = 'customer'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Overview</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Loyal</div>
            <ul>
                <li><a href="admin.php">Back</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Dashboard Overview</h1>
        <section class="glass-card">
            <h2>Clients and Subscriptions</h2>
            <table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Subscription</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td data-subscription=\"" . htmlspecialchars($row['subscription']) . "\">" . 
                     htmlspecialchars($row['subscription']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No clients found</td></tr>";
        }
        ?>
    </tbody>
</table>
        </section>
    </main>

    <footer>
        <p>© 2025 Rewards Platform. All rights reserved.</p>
    </footer>
</body>
</html>