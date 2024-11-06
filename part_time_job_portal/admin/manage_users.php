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

// Fetch all users from the database
$sql = "SELECT * FROM users"; // Adjust the query as per your schema
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Check if a delete request is made
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];

    // Delete user from database
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param('i', $user_id);

    if ($delete_stmt->execute()) {
        // Redirect back to the same page to refresh user list after deletion
        header('Location: manage_users.php');
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
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
    <title>Manage Users</title>

    <style>
        /* Basic styling */
        body {
            background-color: #f4f6f8;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        .edit-button, .delete-button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }

        .edit-button {
            background-color: #2ecc71;
        }

        .delete-button {
            background-color: #e74c3c;
        }

        .delete-button:hover {
            background-color: #c0392b;
        }

        .edit-button:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
<header class="header">
        <div class="header-content">
        <h1>Manage Users</h1>
            <nav>
                <ul class="nav-menu">
                    <li><a href="admin.php">Dashboard</a></li>
                    <li><a href="add_job.php">Add Jobs</a></li>
                    <li><a href="manage_jobs.php">Manage Jobs</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    

    <!-- Display users in a table -->
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <!-- Edit user -->
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="edit-button">Edit</a>

                            <!-- Delete user (with confirmation) -->
                            <a href="manage_users.php?delete_user=<?php echo $user['id']; ?>" 
                               class="delete-button" 
                               onclick="return confirm('Are you sure you want to delete this user?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
