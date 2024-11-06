<?php
session_start(); // Start the session to access session variables

// Database connection details
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "job_portal";

// Create a connection to the database
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $title = $conn->real_escape_string($_POST['title']);
    $company = $conn->real_escape_string($_POST['company']);
    $job_type = $conn->real_escape_string($_POST['job_type']);
    $salary = $conn->real_escape_string($_POST['salary']);
    $location = $conn->real_escape_string($_POST['location']);
    $age_category = $conn->real_escape_string($_POST['age_category']);
    $gender_preference = $conn->real_escape_string($_POST['gender_preference']);
    $description = $conn->real_escape_string($_POST['description']);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO jobs (title, company, job_type, salary, location, age_category, gender_preference, description, posted_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssssss", $title, $company, $job_type, $salary, $location, $age_category, $gender_preference, $description);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New job listing added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add New Job - Admin Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light gray background */
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
            padding: 15px 20px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-menu li {
            display: inline;
            margin-left: 15px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .add-job-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 100px); /* Adjusting height based on header */
            margin-top: 200px;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px; /* Increased width for better layout */
            text-align: left;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            transition: border 0.3s;
            font-size: 14px; /* Ensuring font size is consistent */
        }

        input[type="text"]:focus,
        textarea:focus,
        select:focus {
            border: 1px solid #007bff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .footer {
            background-color: #007bff; /* Match header */
            color: white;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <h1>Add New Job</h1>
            <nav>
                <ul class="nav-menu">
                    <li><a href="admin.php">Dashboard</a></li>
                    <li><a href="manage_jobs.php">Manage Jobs</a></li>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="add-job-section">
        <div class="form-container">
            <h2>Add a New Job Listing</h2>
            <form action="process_add_job.php" method="post">
                <label for="title">Job Title:</label>
                <input type="text" name="title" id="title" required>

                <label for="company">Company:</label>
                <input type="text" name="company" id="company" required>

                <label for="job_type">Job Type:</label>
                <select name="job_type" id="job_type" required>
                    <option value="">Select Job Type</option>
                    <option value="Full-Time">Full-Time</option>
                    <option value="Part-Time">Part-Time</option>
                    <option value="Contract">Contract</option>
                </select>

                <label for="salary">Salary:</label>
                <input type="text" name="salary" id="salary" required placeholder="e.g., 50000.00">

                <label for="location">Location:</label>
                <input type="text" name="location" id="location" required>

                <label for="age_category">Age Category (Optional):</label>
                <input type="text" name="age_category" id="age_category">

                <label for="gender_preference">Gender Preference:</label>
                <select name="gender_preference" id="gender_preference">
                    <option value="Any">Any</option>
                    <option value="Boy">Boy</option>
                    <option value="Girl">Girl</option>
                </select>

                <label for="description">Job Description:</label>
                <textarea name="description" id="description" rows="5" required></textarea>

                <button type="submit">Add Job</button>
            </form>
        </div>
    </section>

 
</body>
</html>
