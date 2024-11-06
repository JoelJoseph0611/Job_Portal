<?php
session_start();

// Database connection settings
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
    echo "<div class='login-prompt'>
            <p>You need to be logged in to apply for this job.</p>
            <a href='login.php' class='login-button'>Log In</a>
          </div>";
    exit;
}

$job_id = isset($_GET['job_id']) && is_numeric($_GET['job_id']) ? $_GET['job_id'] : null;

if ($job_id) {
    $sql = "SELECT title, company FROM jobs WHERE id = $job_id";
    $result = $conn->query($sql);

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
    $user_id = $_SESSION['user_id'];

    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $resume = $_FILES['resume'];
        $resumeData = file_get_contents($resume['tmp_name']);
        $resumeData = $conn->real_escape_string($resumeData);
        $resumeName = $resume['name'];
        $resumeMimeType = mime_content_type($resume['tmp_name']);

        $sql = "INSERT INTO applications (job_id, user_id, resume, resume_name, resume_mime_type, status) 
                VALUES ('$job_id', '$user_id', '$resumeData', '$resumeName', '$resumeMimeType', 'pending')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Your application has been submitted successfully!');
                    setTimeout(function() {
                        window.location.href = 'home.php';
                    });
                  </script>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    } else {
        echo "<p>Please upload a valid resume file.</p>";
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
    <title>Apply for <?php echo htmlspecialchars($job['title']); ?></title>

    <style>
        body {
            background: linear-gradient(to right, #2980b9, #6dd5fa, #ffffff);
            padding: 20px;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .application-container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 500px;
        }

        .job-title {
            font-size: 24px;
            font-weight: bold;
            color: #3498db;
            margin-bottom: 15px;
            text-align: center;
        }

        .form-group {
            margin: 15px 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .form-group textarea {
            width: 100%;
            height: 120px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            resize: none;
        }

        .submit-button {
            width: 100%;
            padding: 14px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .submit-button:hover {
            background-color: #2980b9;
        }

        .login-prompt {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }

        .login-prompt p {
            font-size: 18px;
            color: #555;
        }

        .login-button {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 20px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="application-container">
        <h1 class="job-title">Apply for <?php echo htmlspecialchars($job['title']); ?> at <?php echo htmlspecialchars($job['company']); ?></h1>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="resume">Upload Resume</label>
                <input type="file" id="resume" name="resume" accept=".pdf, .doc, .docx" required>
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
