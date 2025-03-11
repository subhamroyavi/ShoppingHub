<?php
include "include/header.php";
include "include/connection.php";



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
                                <form action="#">
                                    <!-- Email Address -->
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                                    </div>

                                    <!-- OTP Section -->
                                    <div class="form-group mb-3">
                                        <label for="otp" class="form-label">OTP <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="otp" placeholder="Enter OTP" required>
                                            <button class="btn btn-outline-secondary" type="button" id="send-otp">Send OTP</button>
                                        </div>
                                        <small class="form-text text-muted">We'll send a one-time password (OTP) to your email.</small>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="login_submit d-flex justify-content-center">
                                        <button class="btn btn-md btn-black-default-hover" type="submit">Login</button>
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

<?php include "include/footer.php" ?>