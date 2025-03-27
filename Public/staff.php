<?php
// staff.php

session_start();

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Include database connection (adjust the path as necessary)
include('../config/db.php');

// Fetch staff data
$query = "SELECT * FROM staff"; // Adjust the table name as necessary
$result = mysqli_query($conn, $query);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
    <title>Staff Management</title>
</head>
<body>
    <div class="staff-container">
        <h2>Staff Management</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td>
                                <button class="button" onclick="window.location.href='edit_staff.php?id=<?php echo $row['id']; ?>'">Edit</button>
                                <button class="button" onclick="if(confirm('Are you sure you want to delete this staff member?')) { window.location.href='delete_staff.php?id=<?php echo $row['id']; ?>'; }">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No staff members found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="table-actions">
            <button class="button add-button" onclick="window.location.href='add_staff.php'">Add New Staff</button>
            <button class="button" onclick="window.location.href='admin.php'">Back to Admin Dashboard</button>
        </div>
    </div>
</body>
</html>
