<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Job Portal</title>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <h1>Welcome to Part-Time Job Portal</h1>
            <nav>
                <ul class="nav-menu">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="jobs.php">Find Jobs</a></li>
                    <?php if ($is_logged_in): ?>
                        <li><a href="logout.php">Logout</a></li> <!-- Logout option -->
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="welcome-content">
            <h2>Discover Amazing Part-Time Job Opportunities!</h2>
            <p>Your dream job is just a click away. Find flexible job options that fit your lifestyle and skills.</p>
            <!-- <button onclick="location.href='register.php'">Join Now</button> -->
        </div>
    </section>

    <!-- Featured Jobs Section -->
    <section class="featured-jobs">
        <h2>Featured Jobs</h2>
        <div class="job-listing">
            <h3>Part-Time Sales Associate</h3>
            <p>Location: New York, NY</p>
            <p>Salary: $15/hr</p>
        </div>
        <div class="job-listing">
            <h3>Freelance Graphic Designer</h3>
            <p>Location: Remote</p>
            <p>Salary: $20/hr</p>
        </div>
        <div class="job-listing">
            <h3>Customer Service Representative</h3>
            <p>Location: Los Angeles, CA</p>
            <p>Salary: $18/hr</p>
        </div>
    </section>

    <!-- Platform Statistics Section -->
    <section class="statistics-section">
        <h2>Our Impact</h2>
        <div class="stats">
            <div class="stat-item">
                <h3>100+</h3>
                <p>Active Job Listings</p>
            </div>
            <div class="stat-item">
                <h3>0</h3>
                <p>Successful Hires</p>
            </div>
            <div class="stat-item">
                <h3>10+</h3>
                <p>Companies</p>
            </div>
        </div>
    </section>

    <!-- Featured Job Categories Section -->
    <section class="featured-categories-section">
        <h2>Explore Job Categories</h2>
        <div class="category">
            <h3>Retail</h3>
            <p>Part-time jobs in stores, supermarkets, and boutiques.</p>
        </div>
        <div class="category">
            <h3>Hospitality</h3>
            <p>Positions in restaurants, cafes, and hotels.</p>
        </div>
        <div class="category">
            <h3>Freelance</h3>
            <p>Opportunities for writers, designers, and developers.</p>
        </div>
        <div class="category">
            <h3>Education</h3>
            <p>Tutoring and teaching jobs for all age groups.</p>
        </div>
    </section>

    <!-- Call-to-Action Section -->
    <section class="cta-section">
        <h2>Ready to Find Your Dream Part-Time Job?</h2>
        <button onclick="location.href='jobs.php'">Get Started Now</button>
    </section>


</body>
</html>
