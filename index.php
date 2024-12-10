<?php
require 'db.php';
session_start();

// Redirect if the user isn't logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /login/login.php');
    exit;
}

// Fetch all job postings
$job_postings = $pdo->query("SELECT * FROM job_postings")->fetchAll();

// Handle job application submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $stmt = $pdo->prepare("INSERT INTO job_applications 
                             (firstname, lastname, email, phone, cover_letter, job_title, resume, username) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $resumePath = '';
    if ($_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $resumePath = 'uploads/' . $_FILES['resume']['name'];
        move_uploaded_file($_FILES['resume']['tmp_name'], $resumePath);
    }

    $stmt->execute([
        $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['phone'], 
        $_POST['cover_letter'], $_POST['job_title'], $_FILES['resume']['name'], $_SESSION['username']
    ]);

    header('Location: /appli/ty.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindHire | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Minimalist & Cool Design -->
    <style>
        /* Page Body with a subtle gradient */
        body {
            background: linear-gradient(to bottom, #e0eafc, #cfdef3);
            font-family: 'Arial', sans-serif;
        }

        /* Navbar Style */
        nav.navbar {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
        }

        /* Application Modal with cool box shadow */
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Table with cleaner visual appeal */
        table.table-striped tbody tr:hover {
            background-color: #d9edf7;
        }

        /* Buttons with hover effect */
        .btn-primary:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        /* Footer */
        footer {
            background: #333;
            color: #fff;
            padding: 10px 0;
            font-size: 14px;
            text-align: center;
            border-top: 2px solid #2575fc;
        }

        /* Search & Responsiveness */
        .form-control {
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <span class="navbar-brand">FindHire</span>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="viewapp.php">View Applications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Job Listings Section -->
    <div class="container mt-4">
        <h3 class="text-center mb-3">Job Listings</h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Location</th>
                    <th>Apply</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($job_postings as $job): ?>
                <tr>
                    <td><?php echo htmlspecialchars($job['job_title']); ?></td>
                    <td><?php echo htmlspecialchars($job['location']); ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#applicationModal"
                                onclick="setJobTitle('<?php echo htmlspecialchars($job['job_title']); ?>')">Apply
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Application Modal -->
    <div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apply for Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="job_title" id="job_title">
                        <div class="form-group">
                            <label>First Name</label>
                            <input class="form-control" name="firstname" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input class="form-control" name="lastname" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input class="form-control" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label>Cover Letter</label>
                            <textarea class="form-control" name="cover_letter" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Resume (PDF)</label>
                            <input class="form-control" type="file" name="resume" accept=".pdf" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function setJobTitle(jobTitle) {
            document.getElementById('job_title').value = jobTitle;
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
