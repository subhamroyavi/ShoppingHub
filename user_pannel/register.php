<?php
// Start session
session_start();
include "include/header.php";
// Include necessary files
include "include/connection.php";

// Handle Registration
if (isset($_POST['register'])) {
    // Sanitize and validate input data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($password !== $confirm_password) {
        echo "<script>
                    alert('Passwords do not match!');
                    window.location.href = 'register.php';
                </script>";
    }

    // Check if user already exists
    $check_user = "SELECT * FROM users WHERE email = '$email' OR phone = '$phone'";
    $result = mysqli_query($conn, $check_user);

    if ((mysqli_num_rows($result) > 0)) {
        if($row = mysqli_fetch_assoc($result)){
            if($row['email'] == $email){
                echo "<script>
                    alert('Email already exists!');
                    window.location.href = 'register.php';
                </script>";
            } else if($row['phone'] == $phone){
                echo "<script>
                    alert('Phone number already exists!');
                    window.location.href = 'register.php';
                </script>";
            }
        }
        echo "<script>
                    alert('Email or phone number already exists!');
                    window.location.href = 'register.php';
                </script>";
    }

    // Insert new user into the database
    $insert_user = "INSERT INTO users (email, phone, password) VALUES ('$email', '$phone', '$hashed_password')";
    if (mysqli_query($conn, $insert_user)) {
        echo "<script>
                    window.location.href = 'login.php';
                </script>";
    } else {
        echo "<script>
                    alert('Error: " . mysqli_error($conn) . "');
                    window.location.href = 'register.php';
                </script>";
    }
}


?>
<!-- ...:::: Start Breadcrumb Section:::... -->
<div class="breadcrumb-section breadcrumb-bg-color--golden">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="breadcrumb-title">Register</h3>
                    <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                        <nav aria-label="breadcrumb">
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                <li class="active" aria-current="page">Register</li>
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
        <div class="row justify-content-center">
            <!-- Register Area Start -->
            <div class="col-lg-6 col-md-8">
                <div class="account_form register" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-center mb-4">Register</h3>
                    <form id="registrationForm" action="#" method="POST">
                        <!-- Email Address -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            <span class="error" id="emailError"></span>
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Phone number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                            <span class="error" id="phoneError"></span>
                        </div>

                        <!-- Password with toggle -->
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

                        <!-- Confirm Password with toggle -->
                        <div class="form-group mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            <span class="error" id="confirmPasswordError"></span>
                        </div>

                        <!-- Submit Button -->
                        <div class="login_submit d-flex justify-content-center">
                            <button class="btn btn-md btn-black-default-hover" type="submit" name="register">Register</button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center mt-3">
                            <p>Already have an account? <a href="login.php" class="text-decoration-none">Login here</a></p>
                        </div>
                    </form>

                    <!-- Display Response Message -->
                    <div id="responseMessage" class="mt-3"></div>
                </div>
            </div>
            <!-- Register Area End -->
        </div>
    </div>
</div> <!-- ...:::: End Customer Login Section :::... -->


<!-- Modal for displaying error messages -->
<!-- <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    .error {
        color: red;
        font-size: 0.9em;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registrationForm');
        const submitButton = document.querySelector('button[name="register"]');

        // Form field elements
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        // Initial state - disable submit button
        submitButton.disabled = true;

        // Function to validate all fields and enable/disable submit button
        function validateForm() {
            const isEmailValid = email_validation();
            const isPhoneValid = phone_validation();
            const isPasswordValid = password_validation();
            const isConfirmPasswordValid = confirmPassword_validation();

            // Only enable the submit button if all validations pass
            submitButton.disabled = !(isEmailValid && isPhoneValid && isPasswordValid && isConfirmPasswordValid);

            return isEmailValid && isPhoneValid && isPasswordValid && isConfirmPasswordValid;
        }

        // Function to validate email
        function email_validation() {
            let email = emailInput;
            let regex = /^[a-z0-9._%+-]+@[a-z.-]+\.[a-zA-Z]{2,}$/;
            if (regex.test(email.value)) {
                email.classList.remove('is-invalid');
                email.classList.add('is-valid');
                document.getElementById("emailError").innerHTML = ``;
                return true;
            } else {
                email.classList.add('is-invalid');
                email.classList.remove('is-valid');
                document.getElementById("emailError").innerHTML = `<strong>Please enter a valid email address.</strong>`;
                return false;
            }
        }

        // Function to validate phone number
        function phone_validation() {
            let phone_no = phoneInput;
            let regex = /^[6-9][0-9]{9}$/;
            if (regex.test(phone_no.value)) {
                phone_no.classList.remove('is-invalid');
                phone_no.classList.add('is-valid');
                document.getElementById("phoneError").innerHTML = ``;
                return true;
            } else {
                phone_no.classList.add('is-invalid');
                phone_no.classList.remove('is-valid');
                document.getElementById("phoneError").innerHTML = `<strong>Please enter a valid phone number.</strong>`;
                return false;
            }
        }

        // Function to validate password
        function password_validation() {
            let password = passwordInput;
            let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (regex.test(password.value)) {
                password.classList.remove('is-invalid');
                password.classList.add('is-valid');
                document.getElementById("passwordError").innerHTML = ``;
                return true;
            } else {
                password.classList.add('is-invalid');
                password.classList.remove('is-valid');
                document.getElementById("passwordError").innerHTML = `<strong><p>Password must contain:</p></strong> 
            <p>Minimum 8 characters</p>
            <p>At least 1 uppercase letter (A-Z)</p>
            <p>At least 1 lowercase letter (a-z)</p>
            <p>At least 1 number (0-9)</p>
            <p>At least 1 special character (!@#$%^&*)</p>`;
                return false;
            }
        }

        // Function to confirm password
        function confirmPassword_validation() {
            let confirm_password = confirmPasswordInput;
            let password = passwordInput.value;

            // Check if the confirm password matches the password
            if (confirm_password.value !== password) {
                confirm_password.classList.add('is-invalid');
                confirm_password.classList.remove('is-valid');
                document.getElementById("confirmPasswordError").innerHTML = `<strong>Passwords do not match</strong>`;
                return false;
            }

            // If the password field is valid and passwords match
            if (passwordInput.classList.contains('is-valid')) {
                confirm_password.classList.remove('is-invalid');
                confirm_password.classList.add('is-valid');
                document.getElementById("confirmPasswordError").innerHTML = ``;
                return true;
            }

            return false;
        }

        // Add input event listeners to all fields for real-time validation
        emailInput.addEventListener('input', function() {
            email_validation();
            validateForm();
        });

        phoneInput.addEventListener('input', function() {
            phone_validation();
            validateForm();
        });

        passwordInput.addEventListener('input', function() {
            password_validation();
            // When password changes, we need to revalidate confirm password
            if (confirmPasswordInput.value) {
                confirmPassword_validation();
            }
            validateForm();
        });

        confirmPasswordInput.addEventListener('input', function() {
            confirmPassword_validation();
            validateForm();
        });

        // Form submission handler
        form.addEventListener('submit', function(event) {
            // Even if button is enabled, double-check validation
            if (!validateForm()) {
                event.preventDefault();
                alert("Please fix the errors in the form before submitting.");
            }
        });

        // Add visual feedback with CSS
        const style = document.createElement('style');
        style.innerHTML = `
        .is-valid {
            border-color: #198754 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .btn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }
    `;
        document.head.appendChild(style);
    });
</script>

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

<?php include "include/footer.php"; ?>