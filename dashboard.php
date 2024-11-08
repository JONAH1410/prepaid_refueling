<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user's microchip details
$chipQuery = "SELECT * FROM microchip WHERE user_id = $userId";
$chipResult = mysqli_query($conn, $chipQuery);
$chip = mysqli_fetch_assoc($chipResult);

// Fetch refueling history
$historyQuery = "SELECT transaction_date, amount FROM refuel_transactions WHERE user_id = $userId ORDER BY transaction_date DESC";
$historyResult = mysqli_query($conn, $historyQuery);

// Fetch current subscription plan
$currentPlan = $chip['current_plan'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Prepaid Microchip Refueling</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            width: 200px;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
    </style>
</head>
<body>
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
        <div class="container my-5">
            <h2>Your Account Dashboard</h2>

           <!-- Card for Current Balance and Subscription Plan -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Account Overview</h5>
        <p class="card-text">Current Balance:<strong> $<?php echo number_format($chip['balance'], 2); ?></strong>
        </p>
        <p class="card-text">Current Subscription Plan:<strong> <?php echo htmlspecialchars($currentPlan); ?></strong>
        </p>
    </div>
</div>

            <!-- Display Refueling History -->
            <h4>Refueling History</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Amount ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($historyResult) > 0) {
                        while ($row = mysqli_fetch_assoc($historyResult)) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['transaction_date']) . "</td>
                                    <td>" . number_format($row['amount'], 2) . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2' class='text-center'>No refueling transactions found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
