<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Database connection
require_once '../Config/Database.php';
$database = new Database();
$db = $database->getConnection();

// Fetch student data
$studentId = $_SESSION['student_id']; // Ensure this corresponds to the session variable
$query = "SELECT StudentID, StudentName, Email, Password FROM students WHERE StudentID = :StudentID"; // Update the column name
$stmt = $db->prepare($query);
$stmt->bindParam(':StudentID', $studentId); // Update the parameter binding
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if student data was found
if (!$student) {
    // If no student data is found, log out and redirect to login
    session_destroy();
    header("Location: login.php");
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $studentName = $_POST['studentName'];
    $email = $_POST['email'];

    // Update student information in the database
    $updateQuery = "UPDATE students SET StudentName = :studentName, Email = :email WHERE StudentID = :StudentID"; // Update the column name
    $updateStmt = $db->prepare($updateQuery);
    $updateStmt->bindParam(':studentName', $studentName);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':StudentID', $studentId); // Update the parameter binding

    if ($updateStmt->execute()) {
        $successMessage = "Profile updated successfully!";
    } else {
        $errorMessage = "Failed to update profile.";
    }
}

// Handle password change
if (isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];

    // Verify current password
    if (password_verify($currentPassword, $student['Password'])) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $passwordUpdateQuery = "UPDATE students SET Password = :password WHERE StudentID = :StudentID"; // Update the column name
        $passwordUpdateStmt = $db->prepare($passwordUpdateQuery);
        $passwordUpdateStmt->bindParam(':password', $hashedPassword);
        $passwordUpdateStmt->bindParam(':StudentID', $studentId); // Update the parameter binding
        $passwordUpdateStmt->execute();

        $successMessage = "Password changed successfully!";
    } else {
        $errorMessage = "Current password is incorrect.";
    }
}

// Handle account deletion
if (isset($_POST['delete_account'])) {
    $deleteQuery = "DELETE FROM students WHERE StudentID = :StudentID"; // Update the column name
    $deleteStmt = $db->prepare($deleteQuery);
    $deleteStmt->bindParam(':StudentID', $studentId); // Update the parameter binding
    $deleteStmt->execute();

    // Logout user and redirect to homepage
    session_destroy();
    header("Location: index.php");
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to the login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Profile Page</title>
    <style>
        body {
    background-color: #f4f4f4; /* Light gray background */
    font-family: Arial, sans-serif;
    color: #333; /* Dark text color */
    margin: 0;
    padding: 20px;
}

.profile-container {
    background: #ffffff; /* White background for the profile container */
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: auto;
}

h2 {
    margin-bottom: 1.5rem;
    color:#333; /* Blue color for headings */
}

label {
    display: block;
    margin: 1rem 0 0.5rem;
    font-weight: bold; /* Bold labels */
}

input[type="text"],
input[type="email"],
input[type="password"],
textarea {
    width: 50%;
    padding: 0.5rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc; /* Light border */
    border-radius: 5px;
    background: #f9f9f9; /* Light background for input fields */
    color: #333; /* Dark text for better readability */
    transition: border 0.3s;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
textarea:focus {
    border-color: #3498db; /* Change border color on focus */
    outline: none; /* Remove default outline */
}

textarea {
    resize: vertical; /* Allow vertical resizing only */
}

input[type="submit"] {
    background: #3498db; /* Blue background */
    color: #fff; /* White text */
    border: none;
    border-radius: 5px;
    padding: 0.5rem;
    cursor: pointer;
    transition: background 0.3s;
}

input[type="submit"]:hover {
    background: #2980b9; /* Darker blue on hover */
}

.back-button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #e74c3c; /* Red background */
    color: white; /* White text */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    
}

.back-button:hover {
    background-color: #c0392b; /* Darker red on hover */
}

.profile-info {
    margin-bottom: 2rem;
    padding: 1rem;
    border: 1px solid #ddd; /* Light border around profile info */
    border-radius: 5px;
    background: #f9f9f9; /* Light background for profile info */
}

.profile-info h3 {
    margin-top: 0;
    color: #333; /* Darker color for subheadings */
}

.profile-info p {
    margin: 0.5rem 0;
}

        
    

    



    </style>
</head>
<body>
    <!-- Header -->
    <?php include '../includes/sub-header1.php'; ?>

    <div class="profile">
        <h2>Profile Page</h2>

        <?php if (isset($successMessage)): ?>
            <p class="success"><?php echo htmlspecialchars($successMessage); ?></p>
        <?php endif; ?>

        <?php if (isset($errorMessage)): ?>
            <p class="error"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>

        <form method="POST">
            <h3>Update Profile</h3>
            <label for="studentName">Student Name:</label>
            <input type="text" name="studentName" value="<?php echo htmlspecialchars($student['StudentName']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($student['Email']); ?>" required>
            
            <button type="submit" name="update">Update Profile</button>
        </form>

        <form method="POST">
            <h3>Change Password</h3>
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" required>
            
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required>
            
            <button type="submit" name="change_password">Change Password</button>
        </form>

        <form method="POST">
            <h3>Delete Account</h3>
            <p>Are you sure you want to delete your account? This action cannot be undone.</p>
            <button type="submit" name="delete_account">Delete Account</button>
        </form>

        <form method="POST">
            <h3>Logout</h3>
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
    <?php
  include '../includes/footer.php';
  ?>

</body>
</html>
