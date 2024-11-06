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

// Fetch jobs posted by the company
$sql = "SELECT title, job_type, salary, location, posted_date FROM jobs WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Jobs</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional CSS -->
    <style>
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
    <h1>Your Posted Jobs</h1>

    <table>
        <tr>
            <th>Job Title</th>
            <th>Job Type</th>
            <th>Salary</th>
            <th>Location</th>
            <th>Date Posted</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($job = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($job['title']); ?></td>
                    <td><?php echo htmlspecialchars($job['job_type']); ?></td>
                    <td><?php echo htmlspecialchars($job['salary']); ?></td>
                    <td><?php echo htmlspecialchars($job['location']); ?></td>
                    <td><?php echo htmlspecialchars($job['posted_date']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No jobs posted yet.</td>
            </tr>
        <?php endif; ?>
    </table>

    <div class="nav">
        <a href="dashboard.php">Back to Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
