<?php
session_start();

// Check if the company is logged in
if (!isset($_SESSION['company_id'])) {
    header('Location: company_login.php'); // Redirect to login if not logged in
    exit();
}

$company_id = $_SESSION['company_id']; // Get the logged-in company's ID

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch applications for jobs posted by the logged-in company
$sql = "
    SELECT applications.resume, applications.status, applications.applied_date, 
           users.name AS applicant_name, users.email AS applicant_email, jobs.title AS job_title,
           applications.resume_name, applications.resume_mime_type, applications.id AS application_id
    FROM applications
    INNER JOIN jobs ON applications.job_id = jobs.id
    INNER JOIN users ON applications.user_id = users.id
    WHERE jobs.company_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();

$applications = []; // Array to hold application data for rendering
while ($row = $result->fetch_assoc()) {
    $applications[] = $row; // Save each row to array
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications Received</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f4f4f4;
        }
        .nav {
            text-align: center;
        }
        .nav a {
            margin: 0 10px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Applications Received</h1>

    <table>
        <tr>
            <th>Applicant Name</th>
            <th>Applicant Email</th>
            <th>Job Title</th>
            <th>Status</th>
            <th>Application Date</th>
            <th>Resume</th>
        </tr>

        <?php if (count($applications) > 0): ?>
            <?php foreach ($applications as $application): ?>
                <tr>
                    <td><?php echo htmlspecialchars($application['applicant_name']); ?></td>
                    <td><?php echo htmlspecialchars($application['applicant_email']); ?></td>
                    <td><?php echo htmlspecialchars($application['job_title']); ?></td>
                    <td><?php echo htmlspecialchars($application['status']); ?></td>
                    <td><?php echo htmlspecialchars($application['applied_date']); ?></td>
                    <td><a href="download.php?application_id=<?php echo htmlspecialchars($application['application_id']); ?>">Download Resume</a></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No applications received yet.</td>
            </tr>
        <?php endif; ?>
    </table>

    <div class="nav">
        <a href="company_dashboard.php">Back to Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
