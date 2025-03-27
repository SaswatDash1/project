<?php
session_start(); // Start the session
require_once '../Config/Database.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $query = "SELECT StudentID, Password FROM students WHERE Email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Check if user exists
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verify the password
        if (password_verify($password, $row['Password'])) {
            // Start the session and store user information
            $_SESSION['student_id'] = $row['StudentID'];
            $_SESSION['email'] = $email;

            // Redirect to dashboard after a delay
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'dashboard.php';
                }, 1000);
            </script>";
            exit();
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('No user found with this email.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Login</title>
    
    <script>
        function showLoader() {
            document.getElementById('loader').style.display = 'flex';
            document.body.classList.add('blur');
            setTimeout(function() {
                document.getElementById('loader').style.display = 'none';
                document.body.classList.remove('blur');
            }, 1000); // Adjust the duration as needed
        }

        function validateForm() {
            const email = document.forms["loginForm"]["email"].value;
            const password = document.forms["loginForm"]["password"].value;

            if (email == "" || password == "") {
                alert("Both fields must be filled out.");
                return false;
            }
            showLoader(); // Show loader on form submit
            return true;
        }
    </script>
</head>
<body>
<?php
  include '../includes/headerlogin.php';
  ?>
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <div class="login-container">
        <h2>Login</h2>
        <form name="loginForm" method="POST" onsubmit="return validateForm();">
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Login">
        </form>
        
        <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
    </div>
</body>
</html>
