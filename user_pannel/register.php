<?php
// Start session
session_start();

// Include Composer's autoloader
require __DIR__ . '/vendor/autoload.php';

// Include necessary files
include "include/header.php";
include "include/connection.php";

// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to generate a random OTP
function generateOTP() {
    return rand(100000, 999999); // Generates a 6-digit OTP
}

// Handle OTP request
if (isset($_POST['send-otp'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Generate OTP and store in session
    $otp = generateOTP();
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 60; // OTP expires in 60 seconds

    // Send OTP via Email
    $mail = new PHPMailer(true);
    $email_status = "";
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'subhamroy3725@gmail.com'; // Replace with your email
        $mail->Password = 'wouxfjakomidelew'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('subhamroy3725@gmail.com', 'Subham Roy');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Registration';
        $mail->Body = "Your OTP is: <b>$otp</b>";

        $mail->send();
        $email_status = "OTP sent to your email.";
    } catch (Exception $e) {
        $email_status = "Failed to send OTP via email: " . $mail->ErrorInfo;
    }

    echo "<script>alert('$email_status');</script>";
}

// Handle Registration
if (isset($_POST['register'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.location.href = 'register.php';</script>";
        exit();
    }

    if (!isset($_SESSION['otp']) || time() > $_SESSION['otp_expiry'] || $otp != $_SESSION['otp']) {
        echo "<script>alert('Invalid or expired OTP!'); window.location.href = 'register.php';</script>";
        exit();
    }

    $check_user = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='$email'"));
    if ($check_user > 0) {
        echo "<script>alert('User already exists!'); window.location.href = 'login.php';</script>";
    } else {
        $query = "INSERT INTO users(email, password) VALUES('$email', '$password')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration successful!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>
<!-- ...:::: Start Breadcrumb Section:::... -->
<div class="breadcrumb-section breadcrumb-bg-color--golden">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="breadcrumb-title">Registration</h3>
                    <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                        <nav aria-label="breadcrumb">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="index.php">Shop</a></li>
                                <li class="active" aria-current="page">Registration</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Breadcrumb Section:::... -->

<!-- Registration Form -->
<div class="customer-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="account_form register">
                    <h3 class="text-center mb-4">Register</h3>
                    <form action="register.php" method="POST" onsubmit="return validateForm()">
                        <div class="form-group mb-3">
                            <label>Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">👁</button>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label>Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm-password')">👁</button>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label>OTP <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="otp" name="otp" required>
                                <button class="btn btn-outline-secondary" type="button" id="send-otp" onclick="sendOtp()">Send OTP</button>
                            </div>
                            <small class="form-text text-muted">OTP will be sent to your email.</small>
                            <p id="otp-timer" class="text-danger"></p>
                        </div>

                        <div class="login_submit d-flex justify-content-center">
                            <button class="btn btn-md btn-black-default-hover" type="submit" name="register">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password show/hide function
function togglePassword(fieldId) {
    let field = document.getElementById(fieldId);
    field.type = field.type === "password" ? "text" : "password";
}

// OTP Timer function
function sendOtp() {
    let email = document.getElementById("email").value;

    if (!email) {
        alert("Please enter your email.");
        return;
    }

    document.getElementById("send-otp").disabled = true;
    let countdown = 60;
    let timer = setInterval(function () {
        document.getElementById("otp-timer").innerText = "Resend OTP in " + countdown + " seconds";
        countdown--;
        if (countdown < 0) {
            clearInterval(timer);
            document.getElementById("otp-timer").innerText = "";
            document.getElementById("send-otp").disabled = false;
        }
    }, 1000);

    // Submit the form to send OTP
    let form = document.createElement("form");
    form.method = "POST";
    form.action = "register.php";

    let emailInput = document.createElement("input");
    emailInput.type = "hidden";
    emailInput.name = "email";
    emailInput.value = email;
    form.appendChild(emailInput);

    let otpInput = document.createElement("input");
    otpInput.type = "hidden";
    otpInput.name = "send-otp";
    otpInput.value = "1";
    form.appendChild(otpInput);

    document.body.appendChild(form);
    form.submit();
}

// Form validation
function validateForm() {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm-password").value;
    let otp = document.getElementById("otp").value;

    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return false;
    }

    if (!otp) {
        alert("Please enter the OTP.");
        return false;
    }

    return true;
}
</script>

<?php include "include/footer.php"; ?>