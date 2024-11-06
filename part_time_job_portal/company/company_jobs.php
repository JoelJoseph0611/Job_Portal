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

// Fetch jobs posted by the logged-in company
$sql = "SELECT * FROM jobs WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if an edit request is made
if (isset($_GET['edit_job'])) {
    $job_id = intval($_GET['edit_job']);
    
    // Ensure the job belongs to the logged-in company
    $check_job_sql = "SELECT * FROM jobs WHERE id = ? AND company_id = ?";
    $check_stmt = $conn->prepare($check_job_sql);
    $check_stmt->bind_param("ii", $job_id, $company_id);
    $check_stmt->execute();
    $job_result = $check_stmt->get_result();

    if ($job_result->num_rows > 0) {
        $job = $job_result->fetch_assoc();
    } else {
        echo "Unauthorized action!";
        exit;
    }
}

// Handle job form submission for adding or editing a job
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $salary = $conn->real_escape_string($_POST['salary']);

    if (isset($_POST['job_id'])) {
        // Update existing job
        $job_id = intval($_POST['job_id']);
        $update_sql = "UPDATE jobs SET title = ?, description = ?, salary = ? WHERE id = ? AND company_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssii", $title, $description, $salary, $job_id, $company_id);
    } else {
        // Add new job
        $insert_sql = "INSERT INTO jobs (title, description, salary, company_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssi", $title, $description, $salary, $company_id);
    }

    if ($stmt->execute()) {
        header('Location: company_jobs.php'); // Redirect to refresh the list
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Jobs - Company</title>
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
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        h2 {
            color: #555;
            margin-bottom: 10px;
        }
        form {
            margin-bottom: 20px;
            padding: 20px;
            background: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        button.back {
            margin-top: 20px;
            background-color: #007bff;
        }
        button.back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Jobs</h1>

        <!-- Job form -->
        <h2><?php echo isset($job) ? "Edit Job" : "Add New Job"; ?></h2>
        <form action="company_jobs.php" method="post">
            <input type="hidden" name="job_id" value="<?php echo isset($job['id']) ? $job['id'] : ''; ?>">
            <label for="title">Job Title:</label>
            <input type="text" name="title" id="title" value="<?php echo isset($job['title']) ? $job['title'] : ''; ?>" required>

            <label for="job_type">Job Type</label>
            <textarea name="job_type" id="job_type" required><?php echo isset($job['job_type']) ? $job['job_type'] : ''; ?></textarea>

            <label for="salary">Salary:</label>
            <input type="text" name="salary" id="salary" value="<?php echo isset($job['salary']) ? $job['salary'] : ''; ?>" required>

            <button type="submit"><?php echo isset($job) ? "Update Job" : "Add Job"; ?></button>
        </form>

        <!-- Job list -->
        <h2>Your Jobs</h2>
        <table>
            <thead>
                <tr>
                    <th>Job ID</th>
                    <th>Title</th>
                    <th>Job Type</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($job = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $job['id']; ?></td>
                            <td><?php echo $job['title']; ?></td>
                            <td><?php echo $job['job_type']; ?></td>
                            <td><?php echo $job['salary']; ?></td>
                            <td class="actions">
                                <a href="company_jobs.php?edit_job=<?php echo $job['id']; ?>">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No jobs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <button class="back" onclick="location.href='company_dashboard.php'">Back to Dashboard</button>
    </div>
</body>
</html>
