<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Database connection
require_once '../Config/Database.php';
$database = new Database();
$db = $database->getConnection();

// Fetch programmes
$query = "SELECT ProgrammeID, ProgrammeName, LevelID, Description, Image FROM programmes";
$stmt = $db->prepare($query);
$stmt->execute();
$programmes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch unique levels for filtering
$levelQuery = "SELECT DISTINCT LevelID FROM programmes";
$levelStmt = $db->prepare($levelQuery);
$levelStmt->execute();
$levels = $levelStmt->fetchAll(PDO::FETCH_COLUMN);

// Handle application submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply'])) {
    $studentID = $_SESSION['student_id']; // Assuming student ID is stored in session
    $programmeID = $_POST['programme_id'];

    // Insert application into the applications table
    $insertQuery = "INSERT INTO applications (StudentID, ProgrammeID) VALUES (:studentID, :programmeID)";
    $insertStmt = $db->prepare($insertQuery);
    $insertStmt->bindParam(':studentID', $studentID);
    $insertStmt->bindParam(':programmeID', $programmeID);

    if ($insertStmt->execute()) {
        echo "<script>alert('Application submitted successfully!');</script>";
    } else {
        echo "<script>alert('Failed to submit application.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Dashboard</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            display: grid;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color:  #f4f4f4;

        }
        h2{
            text-align: center;
            margin-top: 1.5rem;
            
        }
        
    </style>
    <script>
        function filterProgrammes() {
            const levelSelect = document.getElementById('levelFilter');
            const selectedLevel = levelSelect.value;
            const tableRows = document.querySelectorAll('.programme-row');

            tableRows.forEach(row => {
                const levelID = row.getAttribute('data-level-id');
                if (selectedLevel === '' || levelID === selectedLevel) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</head>
<body>
    
  <!-- header -->
  <?php
  include '../includes/sub-header1.php';
  ?>
    <div class="dashboard">
        <h2>Welcome to Your Dashboard</h2>
        <p>You are logged in as: <?php echo $_SESSION['email']; ?></p>
        <p><a href="dashboard.php?logout=true">Logout</a></p>

        <h3>Programmes</h3>
        
        <!-- Filter Dropdown -->
        <label for="levelFilter">Filter by Level:</label>
        <select id="levelFilter" onchange="filterProgrammes()">
            <option value="">All Levels</option>
            <?php foreach ($levels as $level): ?>
                <option value="<?php echo htmlspecialchars($level); ?>">Level <?php echo htmlspecialchars($level); ?></option>
            <?php endforeach; ?>
        </select>

        <table>
            <thead>
                <tr>
                    <th>Programme ID</th>
                    <th>Programme Name</th>
                    <th>Level ID</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($programmes)): ?>
                    <?php foreach ($programmes as $programme): ?>
                        <tr class="programme-row" data-level-id="<?php echo htmlspecialchars($programme['LevelID']); ?>">
                            <td><?php echo htmlspecialchars($programme['ProgrammeID']); ?></td>
                            <td><?php echo htmlspecialchars($programme['ProgrammeName']); ?></td>
                            <td><?php echo htmlspecialchars($programme['LevelID']); ?></td>
                            <td><?php echo htmlspecialchars($programme['Description']); ?></td>
                            <td>
                                <?php if ($programme['Image']): ?>
                                    <img src="<?php echo htmlspecialchars($programme['Image']); ?>" alt="<?php echo htmlspecialchars($programme['ProgrammeName']); ?>" style="width: 100px;">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="programme_id" value="<?php echo htmlspecialchars($programme['ProgrammeID']); ?>">
                                    <button type="submit" name="apply">Apply</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No programmes found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
  include '../includes/footer.php';
  ?>

    
</body>
</html>
