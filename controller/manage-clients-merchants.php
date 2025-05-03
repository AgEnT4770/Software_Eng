<?php
include '../db.php'; // Database connection

// Fetch customers and merchants
$sql = "SELECT id, name, email, role FROM users WHERE role IN ('customer', 'merchant') ORDER BY role";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Clients & Merchants</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mange_cust&mach.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../views/admin.php">Back</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Managing Users</h1>
        <div class="report-container">
            <!-- Customers Section -->
            <section id="customer-section">
                <h2>Customers</h2>
                <div class="search-bar">
                    <input type="text" id="customer-search" placeholder="Search by customer name..." onkeyup="searchUsers('customer')">
                </div>
                <button class="add-btn" onclick="window.location.href='add-user.php?role=customer'">
                    <i class="bi bi-plus-circle"></i> Add Customer
                </button>
                <div class="user-list" id="customer-list">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        if ($row['role'] == 'customer') {
                            echo "<div class='user-item'>
                                <p>Name: {$row['name']} | Email: {$row['email']}</p>
                                <div>
                                    <a href='edit-user.php?id={$row['id']}' class='edit-btn'><i class='bi bi-pencil-square'></i> Edit</a>
                                    <button class='delete-btn' onclick='deleteUser({$row['id']})'><i class='bi bi-trash'></i> Delete</button>
                                </div>
                            </div>";
                        }
                    }
                    ?>
                </div>
            </section>

            <!-- Merchants Section -->
            <section id="merchant-section">
                <h2>Merchants</h2>
                <div class="search-bar">
                    <input type="text" id="merchant-search" placeholder="Search by merchant name..." onkeyup="searchUsers('merchant')">
                </div>
                <button class="add-btn" onclick="window.location.href='add-user.php?role=merchant'">
                    <i class="bi bi-plus-circle"></i> Add Merchant
                </button>
                <div class="merchant-list" id="merchant-list">
                    <?php
                    // Reset result set for merchants
                    $result->data_seek(0); 
                    while ($row = $result->fetch_assoc()) {
                        if ($row['role'] == 'merchant') {
                            echo "<div class='merchant-item'>
                                <p>Name: {$row['name']} | Email: {$row['email']}</p>
                                <div>
                                    <a href='edit-user.php?id={$row['id']}' class='edit-btn'><i class='bi bi-pencil-square'></i> Edit</a>
                                    <button class='delete-btn' onclick='deleteUser({$row['id']})'><i class='bi bi-trash'></i> Delete</button>
                                </div>
                            </div>";
                        }
                    }
                    ?>
                </div>
            </section>
        </div>
    </main>

    <script>
        function searchUsers(type) {
            let searchInput = document.getElementById(type + '-search').value.toLowerCase();
            let items = document.querySelectorAll('#' + type + '-list .user-item, #' + type + '-list .merchant-item');
            items.forEach(item => {
                let name = item.querySelector('p').innerText.toLowerCase();
                item.style.display = name.includes(searchInput) ? "" : "none";
            });
        }

        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = "delete-user.php?id=" + userId;
            }
        }
    </script>
</body>
</html>