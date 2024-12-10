<?php
require 'db.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: adminLogin.php');
    exit;
}

// Fetch job postings
$stmt = $pdo->query("SELECT * FROM job_postings");
$job_postings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindHire | Manage Jobs</title>
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS for Simplicity & Cool Design -->
    <style>
        /* Background Gradient */
        body {
            background: linear-gradient(to bottom, #a1c4fd, #c2e9fb);
            font-family: 'Arial', sans-serif;
            margin: 0;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
        }

        /* Footer Styling */
        footer {
            background: linear-gradient(to right, #00d2ff, #3c3c3c);
            color: white;
            padding: 10px 0;
            text-align: center;
            font-size: 14px;
        }

        /* Main Content with some padding */
        main {
            padding: 20px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            margin: 20px auto;
            max-width: 1200px;
        }

        /* Table Styling */
        table {
            border-radius: 10px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        /* Buttons for Edit/Delete */
        .btn-info,
        .btn-danger {
            transition: transform 0.2s ease;
        }

        .btn-info:hover,
        .btn-danger:hover {
            transform: scale(1.1);
        }

        /* Responsive Search Bar */
        #search {
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">FindHire</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../adminLogout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="mb-4 text-center">
            <h2>💼 Manage Job Postings</h2>
            <p>Here you can view, edit, or delete job postings easily.</p>
        </div>

        <!-- Search Box -->
        <div class="input-group mb-4">
            <input type="text" id="search" class="form-control" placeholder="Search for jobs...">
            <button class="btn btn-outline-secondary" type="button">Search</button>
        </div>

        <!-- Jobs Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Salary</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($job_postings as $job) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($job['job_title']); ?></td>
                            <td><?php echo htmlspecialchars($job['job_description']); ?></td>
                            <td><?php echo htmlspecialchars($job['location']); ?></td>
                            <td><?php echo htmlspecialchars($job['salary']); ?></td>
                            <td><?php echo htmlspecialchars($job['last_updated']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $job['job_id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                <a href="delete.php?id=<?php echo $job['job_id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; <?= date("Y"); ?> FindHire &mdash; All rights reserved.</p>
    </footer>

    <!-- Load JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

