<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

require_once '../Config/Database.php';
$database = new Database();
$db = $database->getConnection();

// Get the logged-in user's StudentID
$studentId = $_SESSION['student_id'];

// Prepare the SQL statement to fetch applications
$query = "SELECT ApplicationID, ProgrammeID, ApplicationDate FROM applications WHERE StudentID = :StudentID ORDER BY ApplicationDate DESC";
$stmt = $db->prepare($query);
$stmt->bindParam(':StudentID', $studentId);
$stmt->execute();

// Fetch all applications
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch programme names (assuming you have a programmes table)
$programmes = [];
$programmeQuery = "SELECT ProgrammeID, ProgrammeName FROM programmes"; // Adjust this query according to your programmes table
$programmeStmt = $db->prepare($programmeQuery);
$programmeStmt->execute();
while ($row = $programmeStmt->fetch(PDO::FETCH_ASSOC)) {
    $programmes[$row['ProgrammeID']] = $row['ProgrammeName'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>My Applications</title>
    <style>
        body {
            background-image: linear-gradient(rgba(4,9,30,0.7),rgba(4,9,30,0.7)),url(../images/background.jpg);
            background-size: cover;
            font-family: Arial, sans-serif;
            color: #fff;
            padding: 20px;
        }
        .applications-container {
            background: transparent;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
            text-align: center;
            color:#fff;
        }
        h2 {
            margin-bottom: 1.5rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
           
        }
        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="applications-container">
    <h2>My Applications</h2>

    <?php if (count($applications) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Application ID</th>
                    <th>Programme Name</th>
                    <th>Date Applied</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($application['ApplicationID']); ?></td>
                        <td><?php echo htmlspecialchars($programmes[$application['ProgrammeID']] ?? 'Unknown Programme'); ?></td>
                        <td><?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($application['ApplicationDate']))); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No applications found.</p>
    <?php endif; ?>

    <button class="back-button" onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
</div>
<?php
  include '../includes/footer.php';
  ?>


</body>
</html>
