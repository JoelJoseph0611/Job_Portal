<?php
// Start the session and connect to the database
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the application_id is provided
if (isset($_GET['application_id']) && is_numeric($_GET['application_id'])) {
    $application_id = $_GET['application_id'];

    // Fetch the resume details
    $sql = "SELECT resume, resume_name, resume_mime_type FROM applications WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $application_id);
    $stmt->execute();
    $stmt->store_result();

    // Check if the application exists and contains a resume
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($resumeData, $resumeName, $resumeMimeType);
        $stmt->fetch();

        // Send the correct headers to force download
        header("Content-Type: $resumeMimeType");
        header("Content-Disposition: attachment; filename=\"$resumeName\"");
        echo $resumeData;
    } else {
        echo "Resume not found.";
    }

    $stmt->close();
} else {
    echo "Invalid application ID.";
}

$conn->close();
?>
