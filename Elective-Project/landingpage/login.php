<?php

    session_start();

    $errors = [
        'login' => $_SESSION['login_error'] ?? '',
        'register' =>  $_SESSION['register_error'] ?? ''
    ];
    $activeForm = $_SESSION['active_form'] ?? 'login';
    session_unset();

    function showError($error){
        return !empty($error) ? "<p class = 'error-message'> $error </p>" : '';
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register - Barangay Purok ni Bulan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <!-- Login Container -->
    <div class="auth-container active" id="login-container">
        <div class="brand-icon">PnB</div>
        <h2 class="auth-title">Welcome Back</h2>
        <p class="auth-subtitle">Log in to access your barangay dashboard.</p>

        <form action="action.php" method="POST">
            <div class="form-group">
                <?php echo showError($errors['login']); ?>
                <label class="form-label">Email Address or Username</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="username" placeholder="Enter your email or username" required>
                    <i class="fa-regular fa-user"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
            </div>

            <div class="flex-between">
                <label class="checkbox-group">
                    <input type="checkbox">
                    <span class="checkbox-label">Remember me</span>
                </label>
                <a href="#" class="forgot-link">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-submit" name="login">
                Sign In <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a id="show-register">Register now</a>
        </div>
    </div>

    <!-- Register Container -->
    <div class="auth-container" id="register-container">
        <div class="auth-header">
            <div class="brand-icon">BG</div>
            <h2 class="auth-title">Create an Account</h2>
            <p class="auth-subtitle">Register as a barangay resident to request services online.</p>
        </div>

        <form action="action.php" method="POST">
            <div class="form-grid">
                <!-- Name Details -->
                <div class="form-group">
                    <label class="form-label">First Name *</label>
                    <input type="text" class="form-control" name="first_name" placeholder="e.g. Juan" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name *</label>
                    <input type="text" class="form-control" name="last_name" placeholder="e.g. Dela Cruz" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Middle Name</label>
                    <input type="text" class="form-control" name="middleName" placeholder="e.g. Santos">
                </div>
                
                <!-- Personal Details -->
                <div class="form-group">
                    <label class="form-label">Date of Birth *</label>
                    <input type="date" class="form-control" name="dob" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Gender *</label>
                    <select class="form-select" name="gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Civil Status</label>
                    <select class="form-select" name="civilStatus">
                        <option value="" disabled selected>Select Status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Separated">Separated</option>
                    </select>
                </div>

                <!-- Contact & Address -->
                <div class="form-group">
                    <label class="form-label">Contact Number</label>
                    <input type="tel" class="form-control" name="contact" placeholder="09XX XXX XXXX" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div class="form-group">
                    <label class="form-label">Purok *</label>
                    <select class="form-select" name="purok" required>
                        <option value="" disabled selected>Select Purok</option>
                        <option value="Purok 1">Purok 1</option>
                        <option value="Purok 2">Purok 2</option>
                        <option value="Purok 3">Purok 3</option>
                        <option value="Purok 4">Purok 4</option>
                        <option value="Purok 5">Purok 5</option>
                        <option value="Purok 6">Purok 6</option>
                        <option value="Purok 7">Purok 7</option>
                    </select>
                </div>
                <div class="form-group full-width">
                    <label class="form-label">Complete Address</label>
                    <input type="text" class="form-control" name="address" placeholder="House No., Street Name">
                </div>

                <!-- Other Details -->
                <div class="form-group">
                    <label class="form-label">Occupation</label>
                    <input type="text" class="form-control" name="occupation" placeholder="e.g. Teacher, Engineer">
                </div>
                <div class="form-group">
                    <label class="form-label">Registered Voter?</label>
                    <select class="form-select" name="voter">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <!-- Auth Details -->
                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email" class="form-control" name="email" placeholder="juan@example.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password *</label>
                    <input type="password" class="form-control" name="password" placeholder="Create a strong password" required>
                </div>
            </div>

            <button type="submit" class="btn-submit" name="register">
                Register Account <i class="fa-solid fa-user-plus"></i>
            </button>
        </form>

        <div class="auth-footer">
            Already registered? <a id="show-login">Sign in here</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginContainer = document.getElementById('login-container');
            const registerContainer = document.getElementById('register-container');
            const showRegisterBtn = document.getElementById('show-register');
            const showLoginBtn = document.getElementById('show-login');

            showRegisterBtn.addEventListener('click', () => {
                loginContainer.classList.remove('active');
                registerContainer.classList.add('active');
            });

            showLoginBtn.addEventListener('click', () => {
                registerContainer.classList.remove('active');
                loginContainer.classList.add('active');
            });
        });
    </script>
</body>
</html>
