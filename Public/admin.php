<?php
// admin.php

session_start();

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Include database connection (adjust the path as necessary)
include('../config/db.php');

// Fetch user data (example query)
$query = "SELECT COUNT(*) as total_users FROM users";
$result = mysqli_query($conn, $query);
$userData = mysqli_fetch_assoc($result);
$totalUsers = $userData['total_users'];

// Fetch site statistics (example query)
$statsQuery = "SELECT COUNT(*) as total_posts FROM posts";
$statsResult = mysqli_query($conn, $statsQuery);
$statsData = mysqli_fetch_assoc($statsResult);
$totalPosts = $statsData['total_posts'];

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="admin-container">
        <h2>Admin Dashboard</h2>
        <div class="admin-grid">
            <div class="card">
                <h3>Manage Users</h3>
                <p>Total Users: <?php echo $totalUsers; ?></p>
                <button class="button" onclick="window.location.href='manage_users.php'">Manage Users</button>
            </div>
            <div class="card">
                <h3>Site Statistics</h3>
                <p>Total Posts: <?php echo $totalPosts; ?></p>
                <button class="button" onclick="window.location.href='site_stats.php'">View Stats</button>
            </div>
            <div class="card">
                <h3>Content Management</h3>
                <p>Manage site content and posts.</p>
                <button class="button" onclick="window.location.href='content_management.php'">Manage Content</button>
            </div>
            <div class="card">
                <h3>Settings</h3>
                <p>Configure site settings.</p>
                <button class="button" onclick="window.location.href='settings.php'">Site Settings</button>
            </div>
        </div>
        <button class="button logout-button" onclick="window.location.href='logout.php'">Logout</button>
    </div>
</body>
</html>
