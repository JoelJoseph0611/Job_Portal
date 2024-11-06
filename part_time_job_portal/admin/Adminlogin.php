<?php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use the connection to escape user inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check if the admin exists in the database
    $sql = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, log the admin in
        $admin = $result->fetch_assoc();
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: admin.php'); // Redirect to admin.php after successful login
        exit();
    } else {
        // Admin does not exist
        $error_message = "Invalid credentials. Please try again or contact the system administrator.";
    }
}

// Close the connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Part-Time Job Portal</title>
    <style>
        body {
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border 0.3s;
        }

        .login-container input[type="text"]:focus,
        .login-container input[type="password"]:focus {
            border: 1px solid #3498db;
            outline: none;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .login-container button:hover {
            background-color: #2980b9;
        }

        .error-message {
            background-color: #f8d7da; /* Light red background */
            color: #721c24; /* Dark red text */
            border: 1px solid #f5c6cb; /* Red border */
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <?php
        // Display error message if there's any
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>
    </div>
</body>
</html>
