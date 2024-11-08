<?php
include 'db.php';

function generateChipId($length = 8) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if username already exists
    $checkStmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Username already exists
        echo "<script>
            alert('Username already exists. Please choose a different username.');
            window.location.href = 'index.php';
        </script>";
    } else {
        // Generate the chipId
        $chipId = generateChipId();

        // Prepared statement to insert user with activation code
        $stmt = $conn->prepare("INSERT INTO users (username, password, chip_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $chipId);

        if ($stmt->execute()) {
            echo "<script>
                alert('Registration successful! Your Chip ID is: $chipId. Please copy and save it, and do not share.');
            </script>";

            echo "<div style='text-align: center; margin-top: 20px;'>
                    <p id='chipId' style='cursor: pointer;' onclick='copyChipId()'>Your Chip ID is: <strong>$chipId</strong></p>
                    <p>(Click on the Chip ID to copy it to clipboard)</p>
                    <form action='index.php' method='get'>
                        <button type='submit'>Back to Register</button>
                    </form>
                  </div>
                  <script>
                    function copyChipId() {
                        var chipId = '$chipId';
                        navigator.clipboard.writeText(chipId).then(function() {
                            alert('Chip ID copied to clipboard: ' + chipId);
                            window.location.href = 'index.php'; // Redirect to index.php after copying
                        }, function(err) {
                            alert('Failed to copy Chip ID.');
                        });
                    }
                  </script>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        // Close the statement
        $stmt->close();
    }

    // Close the check statement
    $checkStmt->close();
}
?>
