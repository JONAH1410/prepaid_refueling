<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please log in first.');
            window.location.href = 'index.php';
          </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chipId = $_POST['chipId'];
    $paymentMethod = $_POST['paymentMethod'];
    $userId = $_SESSION['user_id'];

    // Verify if chipId exists in the users table
    $verifyChipQuery = $conn->prepare("SELECT chip_id FROM users WHERE chip_id = ? AND user_id = ?");
    $verifyChipQuery->bind_param("si", $chipId, $userId);
    $verifyChipQuery->execute();
    $verifyChipQuery->store_result();

    if ($verifyChipQuery->num_rows == 0) {
        echo "<script>
                alert('Invalid or unauthorized chip ID. Please check and try again.');
                window.location.href = 'activate.php';
              </script>";
        $verifyChipQuery->close();
        exit();
    }
    $verifyChipQuery->close();

    // Prepare additional fields for each payment method
    $cardNumber = null;
    $expiryDate = null;
    $ccv = null;
    $phoneNumber = null;

    if ($paymentMethod == "Visa") {
        $cardNumber = $_POST['visaCardNumber'];
        $expiryDate = $_POST['visaExpiryDate'];
        $ccv = $_POST['visaCCV'];
    } elseif ($paymentMethod == "MasterCard") {
        $cardNumber = $_POST['masterCardNumber'];
        $expiryDate = $_POST['masterExpiryDate'];
        $ccv = $_POST['masterCCV'];
    } elseif ($paymentMethod == "MPesa") {
        $phoneNumber = $_POST['mpesaPhoneNumber'];
    }

    // Insert data into the microchip table
    $query = "INSERT INTO microchip (chip_id, user_id, payment_method, card_number, expiry_date, ccv, phone_number)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "sisssss",
        $chipId,
        $userId,
        $paymentMethod,
        $cardNumber,
        $expiryDate,
        $ccv,
        $phoneNumber
    );

    if ($stmt->execute()) {
        echo "<script>
                alert('Microchip activated successfully!');
                window.location.href = 'dashboard.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>
