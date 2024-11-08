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
        /* Hide payment forms by default */
        #visaForm, #masterCardForm, #mpesaForm {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h5 class="text-center">Menu</h5>
        <div class="d-flex flex-column">
            <a href="dashboard.php" class="btn btn-outline-primary mb-2">Dashboard</a>
            <a href="activate.html" class="btn btn-outline-primary mb-2">Activate New Microchip</a>
            <a href="subscription.php" class="btn btn-outline-secondary mb-2">View/Change Subscription Plans</a>
            <a href="refuel.html" class="btn btn-outline-success mb-2">Refuel Now</a>
            <a href="logout.php" class="btn btn-outline-danger mb-2">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container my-5">
            <h2>Activate Your Microchip</h2>
            <form action="activate_microchip.php" method="post" onsubmit="return validatePaymentForm()">
                <div class="mb-3">
                    <label for="chipId" class="form-label">Microchip ID</label>
                    <input type="text" class="form-control" id="chipId" name="chipId" required>
                </div>
                <div class="mb-3">
                    <label for="paymentMethod" class="form-label">Payment Method</label>
                    <select class="form-select" id="paymentMethod" name="paymentMethod" required onchange="togglePaymentForm()">
                        <option value="" disabled selected>Select a payment method</option>
                        <option value="MPesa">M-Pesa</option>
                        <option value="Visa">Visa</option>
                        <option value="MasterCard">MasterCard</option>
                    </select>
                </div>
                
                <!-- Visa form fields -->
                <div id="visaForm">
                    <h5>Visa Payment Details</h5>
                    <div class="mb-3">
                        <label for="visaCardNumber" class="form-label">Card Number</label>
                        <input type="text" class="form-control" id="visaCardNumber" name="visaCardNumber" maxlength="16">
                    </div>
                    <div class="mb-3">
                        <label for="visaExpiryDate" class="form-label">Expiry Date (MM/YY)</label>
                        <input type="text" class="form-control" id="visaExpiryDate" name="visaExpiryDate" placeholder="MM/YY">
                    </div>
                    <div class="mb-3">
                        <label for="visaCCV" class="form-label">CCV</label>
                        <input type="text" class="form-control" id="visaCCV" name="visaCCV" maxlength="3">
                    </div>
                </div>

                <!-- MasterCard form fields -->
                <div id="masterCardForm">
                    <h5>MasterCard Payment Details</h5>
                    <div class="mb-3">
                        <label for="masterCardNumber" class="form-label">Card Number</label>
                        <input type="text" class="form-control" id="masterCardNumber" name="masterCardNumber" maxlength="16">
                    </div>
                    <div class="mb-3">
                        <label for="masterExpiryDate" class="form-label">Expiry Date (MM/YY)</label>
                        <input type="text" class="form-control" id="masterExpiryDate" name="masterExpiryDate" placeholder="MM/YY">
                    </div>
                    <div class="mb-3">
                        <label for="masterCCV" class="form-label">CCV</label>
                        <input type="text" class="form-control" id="masterCCV" name="masterCCV" maxlength="3">
                    </div>
                </div>

                <!-- M-Pesa form fields -->
                <div id="mpesaForm">
                    <h5>M-Pesa Payment Details</h5>
                    <div class="mb-3">
                        <label for="mpesaPhoneNumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="mpesaPhoneNumber" name="mpesaPhoneNumber" maxlength="10">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Activate</button>
            </form>
        </div>
    </div>

    <script>
        function togglePaymentForm() {
            var paymentMethod = document.getElementById("paymentMethod").value;
            document.getElementById("visaForm").style.display = (paymentMethod === "Visa") ? "block" : "none";
            document.getElementById("masterCardForm").style.display = (paymentMethod === "MasterCard") ? "block" : "none";
            document.getElementById("mpesaForm").style.display = (paymentMethod === "MPesa") ? "block" : "none";
        }

        function validatePaymentForm() {
            var paymentMethod = document.getElementById("paymentMethod").value;

            if (paymentMethod === "Visa") {
                // Visa card validation
                var cardNumber = document.getElementById("visaCardNumber").value;
                var expiryDate = document.getElementById("visaExpiryDate").value;
                var ccv = document.getElementById("visaCCV").value;
                if (!/^4[0-9]{15}$/.test(cardNumber)) {
                    alert("Please enter a valid 16-digit Visa card number starting with 4.");
                    return false;
                }
                if (!validateExpiryDate(expiryDate)) {
                    alert("Please enter a valid expiry date in MM/YY format.");
                    return false;
                }
                if (!/^[0-9]{3}$/.test(ccv)) {
                    alert("Please enter a valid 3-digit CCV.");
                    return false;
                }
            } else if (paymentMethod === "MasterCard") {
                // MasterCard validation
                var cardNumber = document.getElementById("masterCardNumber").value;
                var expiryDate = document.getElementById("masterExpiryDate").value;
                var ccv = document.getElementById("masterCCV").value;
                if (!/^5[1-5][0-9]{14}$|^2(2[2-9]|[3-7][0-9])[0-9]{12}$/.test(cardNumber)) {
                    alert("Please enter a valid 16-digit MasterCard number.");
                    return false;
                }
                if (!validateExpiryDate(expiryDate)) {
                    alert("Please enter a valid expiry date in MM/YY format.");
                    return false;
                }
                if (!/^[0-9]{3}$/.test(ccv)) {
                    alert("Please enter a valid 3-digit CCV.");
                    return false;
                }
            } else if (paymentMethod === "MPesa") {
                // M-Pesa validation
                var phoneNumber = document.getElementById("mpesaPhoneNumber").value;
                if (!/^\d{10}$/.test(phoneNumber)) {
                    alert("Please enter a valid 10-digit phone number for M-Pesa.");
                    return false;
                }
            }
            return true;
        }

        function validateExpiryDate(expiryDate) {
            var expiryDateRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
            if (!expiryDateRegex.test(expiryDate)) return false;
            var parts = expiryDate.split("/");
            var month = parseInt(parts[0], 10);
            var year = parseInt("20" + parts[1], 10);
            var today = new Date();
            var expiry = new Date(year, month - 1);
            return expiry > today;
        }
    </script>
</body>
</html>
