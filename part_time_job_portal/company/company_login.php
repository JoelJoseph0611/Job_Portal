<?php
session_start(); // Start session to store company login data

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

// Initialize variables for storing error messages
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get company login details from form
    $company_name = $conn->real_escape_string($_POST['company_name']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if the company name and password are not empty
    if (!empty($company_name) && !empty($password)) {
        // Query to check if the company exists with provided credentials
        $sql = "SELECT id, company_name, password FROM companies WHERE company_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $company_name);
        $stmt->execute();
        $result = $stmt->get_result();

        // If a company is found
        if ($result->num_rows == 1) {
            $company = $result->fetch_assoc();
            // Check if the password matches
            if ($password === $company['password']) {
                // Set session variables and redirect to the company dashboard
                $_SESSION['company_id'] = $company['id'];
                $_SESSION['company_name'] = $company['company_name'];
                header('Location: company_jobs.php');
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No company found with that name.";
        }
    } else {
        $error = "Please fill in both fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Login</title>
    <link rel="stylesheet" href="Companystyle.css"> <!-- Optional CSS -->
</head>
<body>
    <h1>Company Login</h1>

    <form action="company_login.php" method="post">
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
