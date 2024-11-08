<?php
include 'db.php';

$query = "SELECT * FROM subscription_plans";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<p>" . $row['plan_name'] . " - " . $row['credits'] . " credits for $" . $row['price'] . "</p>";
}
?>
