<?php
// Start the session to use session variables
session_start();

// Ensure the admin is logged in (example logic)
// if (!isset($_SESSION['admin_logged_in'])) {
//     header('Location: Adminlogin.php'); // Redirect to admin login if not logged in
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

// Fetch job listings from the database
$sql = "SELECT * FROM jobs ORDER BY posted_date DESC"; // Adjust the query as per your schema
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error); // Debugging query error
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin - Manage Job Listings</title>

    <style>
        /* Styling for the admin job listings page */
        body {
            background: #f4f6f8;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .search-container {
            text-align: center;
            margin: 20px 0;
        }

        .search-input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .job-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }

        .job-title {
            font-size: 22px;
            font-weight: bold;
            color: #3498db;
            text-decoration: none;
        }

        .job-details {
            margin: 10px 0;
            color: #555;
        }

        .admin-actions {
            margin-top: 10px;
        }

        .admin-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        .admin-button.edit {
            background-color: #28a745; /* Green color for edit */
        }

        .admin-button.delete {
            background-color: #dc3545; /* Red color for delete */
        }

        .admin-button:hover {
            background-color: #2980b9;
        }

        .admin-button.delete:hover {
            background-color: #c82333;
        }

        .admin-button.edit:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<header class="header">
        <div class="header-content">
        <h1>Manage Job Listings</h1>
            <nav>
                <ul class="nav-menu">
                    <li><a href="admin.php">Dashboard</a></li>
                    <li><a href="add_job.php">Add Jobs</a></li>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    

    <!-- Search bar -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Search jobs...">
    </div>

    <div id="jobListings">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($job = $result->fetch_assoc()): ?>
                <div class="job-container" data-job="<?php echo strtolower($job['title'] . ' ' . $job['company'] . ' ' . $job['location'] . ' ' . $job['job_type']); ?>">
                    <a href="job-details.php?job_id=<?php echo $job['id']; ?>" class="job-title">
                        <?php echo $job['title']; ?>
                    </a>
                    <div class="job-details">
                        <p><strong>Company:</strong> <?php echo $job['company']; ?></p>
                        <p><strong>Job Type:</strong> <?php echo $job['job_type']; ?></p> <!-- e.g., 'Part-time' or 'Full-time' -->
                        <p><strong>Salary:</strong> <?php echo $job['salary']; ?></p>
                        <p><strong>Location:</strong> <?php echo $job['location']; ?></p>
                        <p><strong>Age Category:</strong> <?php echo $job['age_category']; ?></p> <!-- e.g., '18-25', '25-35' -->
                        <p><strong>Gender Preference:</strong> <?php echo $job['gender_preference']; ?></p> <!-- e.g., 'Boy/Girl' -->
                        <p><strong>Posted on:</strong> <?php echo date("F j, Y", strtotime($job['posted_date'])); ?></p>
                    </div>
                    <div class="admin-actions">
                        <a href="edit_job.php?job_id=<?php echo $job['id']; ?>" class="admin-button edit">Edit</a>
                        <a href="delete_job.php?job_id=<?php echo $job['id']; ?>" class="admin-button delete" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No job listings available at the moment.</p>
        <?php endif; ?>
    </div>

    <script>
        // JavaScript for the search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const jobContainers = document.querySelectorAll('.job-container');

            jobContainers.forEach(function(jobContainer) {
                const jobText = jobContainer.getAttribute('data-job');
                if (jobText.includes(searchValue)) {
                    jobContainer.style.display = 'block';
                } else {
                    jobContainer.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
