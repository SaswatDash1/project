<?php
require_once '../Config/Database.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $studentName = $_POST['studentName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $termsAccepted = isset($_POST['terms']);

    // Validate the form
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.');</script>";
    } elseif (!$termsAccepted) {
        echo "<script>alert('You must accept the terms and conditions.');</script>";
    } else {
        // Hashing the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement
        $query = "INSERT INTO students (StudentName, Email, Password) VALUES (:studentName, :email, :password)";
        $stmt = $db->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':studentName', $studentName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Signup successful!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Signup failed! Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/stylesignup.css">
    <title>Signup</title>
    <script>
        function validateForm() {
            const studentName = document.forms["signupForm"]["studentName"].value;
            const email = document.forms["signupForm"]["email"].value;
            const password = document.forms["signupForm"]["password"].value;
            const confirmPassword = document.forms["signupForm"]["confirmPassword"].value;

            if (studentName == "" || email == "" || password == "" || confirmPassword == "") {
                alert("All fields must be filled out.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h2>Signup</h2>
    <form name="signupForm" method="POST" onsubmit="return validateForm();">
        <label for="studentName">Student Name:</label>
        <input type="text" name="studentName" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" required><br>

        <label>
            <input type="checkbox" name="terms" required> I accept the <a href="terms.php" target="_blank">terms and conditions</a>
        </label><br>

        <input type="submit" value="Signup">
    </form>
    
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</body>
</html>
