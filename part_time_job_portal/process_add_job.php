<?php
// Start the session (if needed)
session_start();

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

    // Prepare and bind the SQL statement to insert data into the "jobs" table
    $stmt = $conn->prepare("INSERT INTO jobs (title, company, job_type, salary, location, age_category, gender_preference) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters (replace placeholders with actual values)
    $stmt->bind_param("sssssss", $title, $company, $job_type, $salary, $location, $age_category, $gender_preference);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New job listing added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
