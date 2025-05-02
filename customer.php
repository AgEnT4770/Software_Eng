<?php
// Start session to manage logged-in customer data
session_start();
include 'db.php'; // Include database connection

// Fetch the logged-in customer's username and subscription details
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Customer";
$email = isset($_SESSION['email']) ? $_SESSION['email'] : "customer@example.com";

// Fetch subscription information from the database
$sql = "SELECT subscription FROM users WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$subscription = $result->fetch_assoc()['subscription'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/customer.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <div class="logo">Loyal</div>
            <ul>
                <li><a href="index.html">Log out</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Personalized Greeting -->
        <h1>Welcome, <?php echo htmlspecialchars($username); ?></h1>

        <!-- Profile Management Section -->
        <section id="profile-management">
            <h2>Profile Management</h2>
            <p>Level: Beginner | Points: 150</p>
            <p><a href="customer-profile.php">Edit Profile Details</a></p>
        </section>

        <!-- Points Accumulation Section -->
        <section id="points-accumulation">
            <h2>Points Accumulation</h2>
            <p>Total Points: 150 | Redeem Points: 100</p>
        </section>

        <!-- Tiered System Section -->
        <section id="tiered-system">
            <h2>Tiered System</h2>
            <p>Current Subscription: <strong><?php echo htmlspecialchars($subscription); ?></strong></p>
            <div class="tier-boxes">
                <div class="tier-box silver">
                    <h3>Silver</h3>
                    <p>Basic rewards with 200 points.</p>
                    <form method="POST" action="subscribe.php">
                        <button type="submit" name="tier" value="Silver" class="subscribe-btn">Subscribe</button>
                    </form>
                </div>
                <div class="tier-box gold">
                    <h3>Gold</h3>
                    <p>Unlock premium rewards with 500 points.</p>
                    <form method="POST" action="subscribe.php">
                        <button type="submit" name="tier" value="Gold" class="subscribe-btn">Subscribe</button>
                    </form>
                </div>
                <div class="tier-box platinum">
                    <h3>Platinum</h3>
                    <p>Exclusive benefits with 1000 points.</p>
                    <form method="POST" action="subscribe.php">
                        <button type="submit" name="tier" value="Platinum" class="subscribe-btn">Subscribe</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Subscription System Section -->
        <section id="subscription">
    <h2>Newsletter Subscription</h2>
    <p>Choose your subscription plan:</p>
    <div class="tier-boxes">
        <div class="tier-box silver">
            <h3>Silver</h3>
            <p>Earn 20 points/month.</p>
            <form class="subscription-form" method="POST" action="subscribe.php">
                <input type="hidden" name="tier" value="Silver" />
                <div class="options">
                    <input type="radio" id="silver-yearly" name="duration" value="yearly" checked />
                    <label for="silver-yearly">Yearly</label>

                    <input type="radio" id="silver-six" name="duration" value="six-months" />
                    <label for="silver-six">6 Months</label>

                    <input type="radio" id="silver-monthly" name="duration" value="monthly" />
                    <label for="silver-monthly">Monthly</label>
                </div>
                <button type="submit" class="subscribe-btn">Subscribe</button>
            </form>
        </div>

        <div class="tier-box gold">
            <h3>Gold</h3>
            <p>Earn 50 points/month.</p>
            <form class="subscription-form" method="POST" action="subscribe.php">
                <input type="hidden" name="tier" value="Gold" />
                <div class="options">
                    <input type="radio" id="gold-yearly" name="duration" value="yearly" checked />
                    <label for="gold-yearly">Yearly</label>

                    <input type="radio" id="gold-six" name="duration" value="six-months" />
                    <label for="gold-six">6 Months</label>

                    <input type="radio" id="gold-monthly" name="duration" value="monthly" />
                    <label for="gold-monthly">Monthly</label>
                </div>
                <button type="submit" class="subscribe-btn">Subscribe</button>
            </form>
        </div>

        <div class="tier-box platinum">
            <h3>Platinum</h3>
            <p>Earn 100 points/month.</p>
            <form class="subscription-form" method="POST" action="subscribe.php">
                <input type="hidden" name="tier" value="Platinum" />
                <div class="options">
                    <input type="radio" id="platinum-yearly" name="duration" value="yearly" checked />
                    <label for="platinum-yearly">Yearly</label>

                    <input type="radio" id="platinum-six" name="duration" value="six-months" />
                    <label for="platinum-six">6 Months</label>

                    <input type="radio" id="platinum-monthly" name="duration" value="monthly" />
                    <label for="platinum-monthly">Monthly</label>
                </div>
                <button type="submit" class="subscribe-btn">Subscribe</button>
            </form>
        </div>
    </div>
</section>

        <!-- Value-Based System Section -->
        <section id="value-based-system">
            <h2><a href="value-based-customer.html">Value-Based System</a></h2>
            <p>Donate points to charity organizations.</p>
        </section>

        <!-- Categories Section -->
        <section id="categories">
            <h2><a href="offer-home.html">Categories</a></h2>
            <p>Explore rewards in various categories.</p>
        </section>

        <!-- Offers Section -->
        <section id="offers">
            <h2><a href="offer-home.html">Best Offers</a></h2>
            <p>Check out the best offers from all categories.</p>
        </section>
    </main>

    <!-- Footer -->
    <footer class="glass-footer">
        <p>Follow us on:</p>
        <ul>
            <li><a href="https://facebook.com" target="_blank"><i class="bi bi-facebook"></i></a></li>
            <li><a href="https://instagram.com" target="_blank"><i class="bi bi-instagram"></i></a></li>
            <li><a href="https://twitter.com" target="_blank"><i class="bi bi-twitter"></i></a></li>
        </ul>
        <p>© 2025 Rewards Platform. All rights reserved.</p>
    </footer>
</body>
</html>