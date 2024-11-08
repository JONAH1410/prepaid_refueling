<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        echo "<script>
                alert('Login successful!');
                window.location.href = 'dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Invalid username or password.');
                window.history.back();
              </script>";
    }
}

