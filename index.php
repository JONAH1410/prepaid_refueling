<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prepaid Microchip Refueling - Login/Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container { display: none; }
        .active-form { display: block; }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Prepaid Microchip Refueling</h1>
        <div class="text-center my-4">
            <button id="showRegister" class="btn btn-primary me-2">Register</button>
            <button id="showLogin" class="btn btn-secondary">Login</button>
        </div>

        <!-- Registration Form -->
        <div id="registerForm" class="form-container active-form">
            <h2>Register</h2>
            <form action="register.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>

        <!-- Login Form -->
        <div id="loginForm" class="form-container">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-secondary">Login</button>
            </form>
        </div>
    </div>

    <script>
        const showRegister = document.getElementById('showRegister');
        const showLogin = document.getElementById('showLogin');
        const registerForm = document.getElementById('registerForm');
        const loginForm = document.getElementById('loginForm');

        showRegister.addEventListener('click', () => {
            registerForm.classList.add('active-form');
            loginForm.classList.remove('active-form');
        });

        showLogin.addEventListener('click', () => {
            loginForm.classList.add('active-form');
            registerForm.classList.remove('active-form');
        });
    </script>
</body>
</html>
