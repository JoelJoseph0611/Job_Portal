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

// Fetch company information
$sql = "SELECT company_name FROM companies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();
$company = $result->fetch_assoc();

// Fetch jobs posted by the company
$sql_jobs = "SELECT COUNT(*) as job_count FROM jobs WHERE company_id = ?";
$stmt_jobs = $conn->prepare($sql_jobs);
$stmt_jobs->bind_param("i", $company_id);
$stmt_jobs->execute();
$result_jobs = $stmt_jobs->get_result();
$job_summary = $result_jobs->fetch_assoc();


// Fetch applications count for jobs posted by the company
$sql_applications = "
    SELECT COUNT(*) as application_count 
    FROM applications 
    INNER JOIN jobs ON applications.job_id = jobs.id 
    WHERE jobs.company_id = ?
";
$stmt_applications = $conn->prepare($sql_applications);
$stmt_applications->bind_param("i", $company_id);
$stmt_applications->execute();
$result_applications = $stmt_applications->get_result();
$application_summary = $result_applications->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $company['company_name']; ?> - Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional CSS -->
    <style>
        /* Basic styling for the dashboard */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
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
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .summary div {
            flex: 1;
            background: #007bff;
            color: white;
            padding: 20px;
            margin: 0 10px;
            border-radius: 5px;
            text-align: center;
        }
        .nav {
            text-align: center;
            margin-top: 20px;
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
    <h1>Welcome, <?php echo $company['company_name']; ?>!</h1>
    
    <div class="summary">
        <div onclick="window.location.href='job_details.php';" style="cursor: pointer;">
            <h2><?php echo $job_summary['job_count']; ?></h2>
            <p>Jobs Posted</p>
    </div>
    <div onclick="window.location.href='applications_received.php';" style="cursor: pointer;">
        <h2><?php echo $application_summary['application_count']; ?></h2> <!-- Replace '0' with dynamic application count -->
        <p>Applications Received</p>
    </div>

    </div>

    <div class="nav">
        <a href="company_jobs.php">Manage Jobs</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
