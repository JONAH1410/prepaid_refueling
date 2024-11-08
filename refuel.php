<?php
session_start();
include 'db.php';

$userId = $_SESSION['user_id'];
$amount = 25;

$query = "SELECT balance FROM microchip WHERE user_id = $userId";
$result = mysqli_query($conn, $query);
$userBalance = mysqli_fetch_assoc($result)['balance'];

if ($userBalance >= $amount) {
    $newBalance = $userBalance - $amount;
    $updateQuery = "UPDATE microchip SET balance = $newBalance WHERE user_id = $userId";
    mysqli_query($conn, $updateQuery);

    $insertTransaction = "INSERT INTO refuel_transactions (user_id, amount) VALUES ($userId, $amount)";
    mysqli_query($conn, $insertTransaction);

    echo "
    Refuel successful! New balance: $ $newBalance
 ";

    echo "Insufficient balance. Please recharge your account.";
}

