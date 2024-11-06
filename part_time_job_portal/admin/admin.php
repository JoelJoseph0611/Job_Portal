<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
$is_admin_logged_in = isset($_SESSION['admin_id']);

if (!$is_admin_logged_in) {
    // Redirect to login page if not logged in as an admin
    header('Location: Adminlogin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard - Part-Time Job Portal</title>

    <style>
         .admin-controls-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            width: 400px;
            text-align: center;
        }

        .admin-controls-section h2 {
            font-size: 26px;
            color: #333;
            margin-bottom: 20px;
        }

        .controls {
            display: flex;
            flex-direction: column;
            gap: 15px; /* Space between buttons */
        }

        .controls button {
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .controls button:hover {
            background-color: #2980b9;
            transform: translateY(-3px); /* Slight lift on hover */
        }

        .controls button:active {
            background-color: #2471a3;
            transform: translateY(0); /* Reset transform on click */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <h1>Admin Dashboard</h1>
            <nav>
                <ul class="nav-menu">
                    <li><a href="admin.php">Dashboard</a></li>
                    <li><a href="manage_jobs.php">Manage Jobs</a></li>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="Adminlogin.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Admin Welcome Section -->
    <section class="welcome-section">
        <div class="welcome-content">
            <h2>Welcome, Admin!</h2>
            <p>Manage job listings, users, and monitor platform activity from your dashboard.</p>
        </div>
    </section>

    <!-- Admin Statistics Section -->
    <section class="statistics-section">
        <h2>Platform Overview</h2>
        <div class="stats">
            <div class="stat-item">
                <h3>20+</h3>
                <p>Active Job Listings</p>
            </div>
            <div class="stat-item">
                <h3>5+</h3>
                <p>Registered Users</p>
            </div>
            <div class="stat-item">
                <h3>15</h3>
                <p>Companies Registered</p>
            </div>
        </div>
    </section>

    <!-- Admin Controls Section -->
   <center>
    <section class="admin-controls-section">
        <h2>Quick Actions</h2>
        <div class="controls">
            <button onclick="location.href='add_job.php'">Add New Job</button>
            <button onclick="location.href='manage_jobs.php'">View All Jobs</button>
            <button onclick="location.href='manage_users.php'">Manage Users</button>
        </div>
    </section>
   </center> 

   
</body>
</html>
