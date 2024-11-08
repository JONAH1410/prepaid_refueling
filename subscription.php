<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please log in first.');
            window.location.href = 'index.php';
          </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate Microchip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container-flex {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            padding-top: 20px;
            height: 100vh;
            position: fixed;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <div class="container-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h5 class="text-center">Menu</h5>
            <div class="d-flex flex-column">
                <a href="dashboard.php" class="btn btn-outline-primary mb-2">Dashboard</a>
                <a href="activate.php" class="btn btn-outline-primary mb-2">Activate New Microchip</a>
                <a href="subscription.php" class="btn btn-outline-secondary mb-2">View/Change Subscription Plans</a>
                <a href="refuel.html" class="btn btn-outline-success mb-2">Refuel Now</a>
                <a href="logout.php" class="btn btn-outline-danger mb-2">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <h2>Choose Your Subscription Plan</h2>
            <form action="subscribe.php" method="POST">
                <ul class="list-group">
                    <li class="list-group-item">
                        <input type="radio" name="plan" value="basic" id="basic" required>
                        <label for="basic">Basic Plan - $50 (50 fuel credits)</label>
                    </li>
                    <li class="list-group-item">
                        <input type="radio" name="plan" value="standard" id="standard">
                        <label for="standard">Standard Plan - $100 (110 fuel credits)</label>
                    </li>
                    <li class="list-group-item">
                        <input type="radio" name="plan" value="premium" id="premium">
                        <label for="premium">Premium Plan - $200 (250 fuel credits)</label>
                    </li>
                </ul>
                <button type="submit" class="btn btn-primary mt-3">Subscribe</button>
            </form>
        </div>
    </div>
</body>
</html>
