<?php
// Start the session to use session variables
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_portal";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to apply for a job.";
    exit;
}

// Get the job ID from the URL
if (isset($_GET['job_id']) && is_numeric($_GET['job_id'])) {
    $job_id = $_GET['job_id'];

    // Fetch job details for confirmation
    $sql = "SELECT title, company FROM jobs WHERE id = $job_id";
    $result = $conn->query($sql);

    // Check if the job exists
    if ($result && $result->num_rows > 0) {
        $job = $result->fetch_assoc();
    } else {
        echo "Job not found.";
        exit;
    }
} else {
    echo "Invalid job ID.";
    exit;
}

// Handle the job application submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Get the logged-in user ID
    $cover_letter = $conn->real_escape_string($_POST['cover_letter']);

    // Insert application into the database
    $sql = "INSERT INTO applications (job_id, user_id, cover_letter, status) 
            VALUES ('$job_id', '$user_id', '$cover_letter', 'pending')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Your application has been submitted successfully!</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Apply for <?php echo $job['title']; ?></title>

    <style>
        /* Styling for the application page */
        body {
            background: #f4f6f8;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .application-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 700px;
        }

        .job-title {
            font-size: 24px;
            font-weight: bold;
            color: #3498db;
            margin-bottom: 10px;
        }

        .form-group {
            margin: 15px 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .submit-button {
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="application-container">
        <h1 class="job-title">Apply for <?php echo $job['title']; ?> at <?php echo $job['company']; ?></h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="cover_letter">Cover Letter</label>
                <textarea id="cover_letter" name="cover_letter" placeholder="Write your cover letter here..." required></textarea>
            </div>
            <button type="submit" class="submit-button">Submit Application</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
