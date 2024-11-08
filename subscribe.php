<?php
// subscribe.php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<script>
                alert('Please log in first.');
                window.location.href = 'indx.php';
              </script>";
        exit();
    }

    $userId = $_SESSION['user_id'];
    $selectedPlan = $_POST['plan'];

    // Fetch selected plan details securely using a prepared statement
    $planQuery = $conn->prepare("SELECT credits, price FROM subscription_plans WHERE plan_name = ?");
    $planQuery->bind_param("s", $selectedPlan);
    $planQuery->execute();
    $planResult = $planQuery->get_result();
    $plan = $planResult->fetch_assoc();

    // Check if the selected plan exists
    if ($plan) {
        $credits = $plan['credits'];
        $price = $plan['price'];

        // Update user's microchip balance and current plan securely
        $updateQuery = $conn->prepare("UPDATE microchip 
                                       SET balance = balance + ?, current_plan = ? 
                                       WHERE user_id = ?");
        $updateQuery->bind_param("dsi", $credits, $selectedPlan, $userId);

        if ($updateQuery->execute()) {
            echo "<script>
                    alert('Subscribed to the $selectedPlan plan! Added $credits fuel credits.');
                    window.location.href = 'activate.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Subscription failed. Please try again.');
                    window.location.href = 'subscription.php';
                  </script>";
        }

        // Close the update statement
        $updateQuery->close();
    } else {
        // Alert if the selected plan does not exist in the database
        echo "<script>
                alert('Invalid subscription plan selected.');
                window.location.href = 'subscription.php';
              </script>";
    }

    // Close the plan query
    $planQuery->close();
}
?>
