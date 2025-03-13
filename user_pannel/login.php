<?php
include "include/header.php";
include "include/connection.php";

// Redirect logged-in users to the index page
if (!empty($_SESSION['user_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

// Handle Login Form Submission
if (isset($_POST['login'])) {
    // Sanitize and validate input data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Password will be hashed and verified

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE (email = '$email' OR phone = '$phone')";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Verify password (assuming passwords are hashed using password_hash())
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_phone'] = $row['phone'];

            // Redirect to index page
            // header("Location: index.php");
            // exit();
            echo "<script>window.location.href='login.php';</script>";
            exit();
        } else {
            // Invalid password
            $_SESSION['error'] = "Invalid email or password.";
            echo "<script>window.location.href='login.php';</script>";
            exit();
        }
    } else {
        // User not found
        $_SESSION['error'] = "Invalid email or password.";

        echo "<script>window.location.href='login.php';</script>";
        exit();
    }
}
?>

<!-- ...:::: Start Breadcrumb Section:::... -->
<div class="breadcrumb-section breadcrumb-bg-color--golden">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="breadcrumb-title">Login</h3>
                    <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                        <nav aria-label="breadcrumb">
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                <li class="active" aria-current="page">Login</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Breadcrumb Section:::... -->

<!-- ...:::: Start Customer Login Section :::... -->
<div class="customer-login">
    <div class="container">
        <div class="row">

            <!-- ...:::: Start Customer Login Section :::... -->
            <div class="customer-login">
                <div class="container">
                    <div class="row justify-content-center">
                        <!-- Register Area Start -->
                        <div class="col-lg-6 col-md-8">
                            <div class="account_form register" data-aos="fade-up" data-aos-delay="200">
                                <h3 class="text-center mb-4">Login</h3>
                                <form action="" method="POST">
                                    <!-- Email Address -->
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email address / Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                        <span class="error" id="passwordError"></span>
                                    </div>

                                    <!-- OTP Section -->
                                    <!-- <div class="form-group mb-3">
                                        <label for="otp" class="form-label">OTP <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="otp" placeholder="Enter OTP" required>
                                            <button class="btn btn-outline-secondary" type="button" id="send-otp">Send OTP</button>
                                        </div>
                                        <small class="form-text text-muted">We'll send a one-time password (OTP) to your email.</small>
                                    </div> -->

                                    <!-- Submit Button -->
                                    <div class="login_submit d-flex justify-content-center">
                                        <button class="btn btn-md btn-black-default-hover" type="submit" name="login">Login</button>
                                    </div>

                                    <!-- Login Link -->
                                    <div class="text-center mt-3">
                                        <p>If you don't have an account? <a href="register.php" class="text-decoration-none">Register here</a></p>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- Register Area End -->
                    </div>
                </div>
            </div>
            <!-- ...:::: End Customer Login Section :::... -->
            <!--register area end-->
        </div>
    </div>
</div> <!-- ...:::: End Customer Login Section :::... -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.toggle-password');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.innerHTML = '<i class="fa fa-eye-slash"></i>';
                } else {
                    passwordInput.type = 'password';
                    this.innerHTML = '<i class="fa fa-eye"></i>';
                }
            });
        });
    });
</script>

<?php include "include/footer.php" ?>