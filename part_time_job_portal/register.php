<?php
// Start the session
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

// Handle form submission when the register form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the passwords match
    if ($password === $confirm_password) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the email or username is already registered
        $check_user = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
        $result = $conn->query($check_user);

        if ($result->num_rows > 0) {
            echo "<p>Email or Username is already registered. Please use a different email or username.</p>";
        } else {
            // Insert the new user into the database
            $sql = "INSERT INTO users (username, email, password, name) VALUES ('$username', '$email', '$hashed_password', '$username')";

            if ($conn->query($sql) === TRUE) {
                echo "<p class='success-message'>Registration successful! You can now <a href='login.php' class='login-link'>login</a>.</p>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "<p>Passwords do not match. Please try again.</p>";
    }
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
    <title>Register - Part-Time Job Portal</title>

    <style>
        
        .success-message {
    background-color: #d4edda; /* Light green background */
    color: #155724; /* Dark green text */
    border: 1px solid #c3e6cb; /* Green border */
    padding: 15px;
    border-radius: 5px;
    margin-top: 20px;
    text-align: center;
    font-size: 16px;
}

.success-message a.login-link {
    color: #155724; /* Match link color with text */
    text-decoration: underline;
    font-weight: bold;
}

.success-message a.login-link:hover {
    color: #0b2e13; /* Darker shade on hover */
}


        body {
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
        }

        .register-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border 0.3s;
        }

        .register-container input[type="text"]:focus,
        .register-container input[type="email"]:focus,
        .register-container input[type="password"]:focus {
            border: 1px solid #3498db;
            outline: none;
        }

        .register-container button {
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

        .register-container button:hover {
            background-color: #2980b9;
        }

        .login-link {
            margin-top: 15px;
            display: block;
            text-decoration: none;
            color: #3498db;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Create Your Account</h2>
        <form action="register.php" method="post" id="registerForm">
    <input type="text" id="username" name="username" placeholder="Username" required>
    <div id="usernameError" style="color: red;"></div>
    
    <input type="email" id="email" name="email" placeholder="Email" required>
    <div id="emailError" style="color: red;"></div>
    
    <input type="password" id="password" name="password" placeholder="Password" required>
    <div id="passwordError" style="color: red;"></div>
    
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
    <div id="confirmPasswordError" style="color: red;"></div>
    
    <button type="submit">Register</button>
</form>
        <a href="login.php" class="login-link">Already have an account? Login here</a>
    </div>






    <script>
document.getElementById('registerForm').addEventListener('submit', function(event) {
    // Prevent the form from submitting by default
    event.preventDefault();

    // Get the form fields
    let username = document.getElementById('username').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirm_password').value;

    // Clear previous error messages
    document.getElementById('usernameError').textContent = '';
    document.getElementById('emailError').textContent = '';
    document.getElementById('passwordError').textContent = '';
    document.getElementById('confirmPasswordError').textContent = '';

    let isValid = true;

    // Username validation
    if (username.length < 3) {
        document.getElementById('usernameError').textContent = 'Username must be at least 3 characters long';
        isValid = false;
    }

    // Email validation (basic)
    const emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|outlook\.com|hotmail\.com|icloud\.com|aol\.com|zoho\.com|protonmail\.com|yandex\.com)$/;
    if (!emailPattern.test(email)) {
        document.getElementById('emailError').textContent = 'Please enter an email address from an allowed provider (e.g., user@gmail.com)';
        isValid = false;
    }

    // Password validation
    const passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/;
    if (!passwordPattern.test(password)) {
        document.getElementById('passwordError').textContent = 'Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, and one number.';
        isValid = false;
    }

    // Confirm password validation
    if (password !== confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
        isValid = false;
    }

    // If the form is valid, submit it
    if (isValid) {
        this.submit();
    }
});
</script>
</body>
</html>
