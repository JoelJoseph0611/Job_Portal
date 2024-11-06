<?php
// Start the session to use session variables
session_start();

// Ensure the admin is logged in
// if (!isset($_SESSION['admin_logged_in'])) {
//     header('Location: admin_login.php'); // Redirect to admin login if not logged in
//     exit();
// }

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

// Check if job_id is provided in the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];

    // Fetch the existing job details based on the job_id
    $sql = "SELECT * FROM jobs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $job_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the job exists
    if ($result->num_rows == 1) {
        $job = $result->fetch_assoc(); // Fetch job details
    } else {
        echo "Job not found.";
        exit();
    }
    
} else {
    echo "No job ID provided.";
    exit();
}

// If the form is submitted, update the job details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the updated job details from the form
    $title = $_POST['title'];
    $company = $_POST['company'];
    $job_type = $_POST['job_type'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $age_category = $_POST['age_category'];
    $gender_preference = $_POST['gender_preference'];

    // Update the job details in the database
    $update_sql = "UPDATE jobs SET title = ?, company = ?, job_type = ?, salary = ?, location = ?, age_category = ?, gender_preference = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('sssssssi', $title, $company, $job_type, $salary, $location, $age_category, $gender_preference, $job_id);

    if ($update_stmt->execute()) {
        // Set a session variable to show success message
        $_SESSION['success_message'] = "Job updated successfully.";
        header('Location: edit_job.php?job_id=' . $job_id); // Redirect to avoid form re-submission
        exit();
    } else {
        echo "Error updating job: " . $conn->error;
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
    <title>Edit Job - Admin</title>
    <style>
        /* Styling for the form */
        body {
            background: #f4f6f8;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .submit-button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-button:hover {
            background-color: #2980b9;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Edit Job</h1>

    <!-- Display the success message if set -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="success-message">
            <?php
            echo $_SESSION['success_message'];
            unset($_SESSION['success_message']); // Remove it after displaying
            ?>
        </div>
    <?php endif; ?>
    
    <div class="form-container">
        <form action="edit_job.php?job_id=<?php echo $job_id; ?>" method="post">
            <div class="form-group">
                <label for="title">Job Title</label>
                <input type="text" id="title" name="title" value="<?php echo $job['title']; ?>" required>
            </div>

            <div class="form-group">
                <label for="company">Company</label>
                <input type="text" id="company" name="company" value="<?php echo $job['company']; ?>" required>
            </div>

            <div class="form-group">
                <label for="job_type">Job Type</label>
                <select id="job_type" name="job_type" required>
                    <option value="Full-Time" <?php if ($job['job_type'] === 'Full-Time') echo 'selected'; ?>>Full-Time</option>
                    <option value="Part-Time" <?php if ($job['job_type'] === 'Part-Time') echo 'selected'; ?>>Part-Time</option>
                </select>
            </div>

            <div class="form-group">
                <label for="salary">Salary</label>
                <input type="text" id="salary" name="salary" value="<?php echo $job['salary']; ?>" required>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="<?php echo $job['location']; ?>" required>
            </div>

            <div class="form-group">
                <label for="age_category">Age Category</label>
                <input type="text" id="age_category" name="age_category" value="<?php echo $job['age_category']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gender_preference">Gender Preference</label>
                <input type="text" id="gender_preference" name="gender_preference" value="<?php echo $job['gender_preference']; ?>" required>
            </div>

            <button type="submit" class="submit-button">Update Job</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
