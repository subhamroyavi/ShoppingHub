<?php
include "include/header.php";
include "include/connection.php";

// Redirect logged-in users to the index page
if (empty($_SESSION['user_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

//account details
if (isset($_POST['submit'])) {
    $firstname = !empty($_POST['firstname']) ? mysqli_real_escape_string($conn, $_POST['firstname']) : NULL;
    $lastname = !empty($_POST['lastname']) ? mysqli_real_escape_string($conn, $_POST['lastname']) : NULL;
    // $email = !empty($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : NULL;
    // $phone = !empty($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : NULL;

    $sql = "UPDATE `users` SET                
    `firstname` = " . ($firstname === NULL ? "NULL" : "'$firstname'") . ",
    `lastname` = " . ($lastname === NULL ? "NULL" : "'$lastname'") . " WHERE `user_id` = '$user_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Account details inserted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

//primary address
if (isset($_POST['submit1'])) {
    $address = !empty($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : NULL;
    $city = !empty($_POST['city']) ? mysqli_real_escape_string($conn, $_POST['city']) : NULL;
    $state = !empty($_POST['state']) ? mysqli_real_escape_string($conn, $_POST['state']) : NULL;
    $country = !empty($_POST['country']) ? mysqli_real_escape_string($conn, $_POST['country']) : NULL;
    $pincode = !empty($_POST['pincode']) ? mysqli_real_escape_string($conn, $_POST['pincode']) : NULL;

    $sql = "UPDATE `users` SET                
                `address` = " . ($address === NULL ? "NULL" : "'$address'") . ",
                `city` = " . ($city === NULL ? "NULL" : "'$city'") . ",
                `state` = " . ($state === NULL ? "NULL" : "'$state'") . ",
                `country` = " . ($country === NULL ? "NULL" : "'$country'") . ",
                `pincode` = " . ($pincode === NULL ? "NULL" : "'$pincode'") . "
            WHERE `user_id` = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Primary Address inserted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

//secondary address
if (isset($_POST['submit2'])) {
    $address2 = !empty($_POST['address2']) ? mysqli_real_escape_string($conn, $_POST['address2']) : NULL;
    $city2 = !empty($_POST['city2']) ? mysqli_real_escape_string($conn, $_POST['city2']) : NULL;
    $state2 = !empty($_POST['state2']) ? mysqli_real_escape_string($conn, $_POST['state2']) : NULL;
    $country2 = !empty($_POST['country2']) ? mysqli_real_escape_string($conn, $_POST['country2']) : NULL;
    $pincode2 = !empty($_POST['pincode2']) ? mysqli_real_escape_string($conn, $_POST['pincode2']) : NULL;


    $sql = "UPDATE `users` SET 
                
                `address2` = " . ($address2 === NULL ? "NULL" : "'$address2'") . ",
                `city2` = " . ($city2 === NULL ? "NULL" : "'$city2'") . ",
                `state2` = " . ($state2 === NULL ? "NULL" : "'$state2'") . ",
                `country2` = " . ($country2 === NULL ? "NULL" : "'$country2'") . ",
                `pincode2` = " . ($pincode2 === NULL ? "NULL" : "'$pincode2'") . "
            WHERE `user_id` = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Secondary Address inserted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

//change password
if (isset($_POST['password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch user's current password from the database
    $sql = "SELECT password FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']); // Assuming user_id is stored in session
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($old_password, $row['password'])) {
        if ($new_password === $confirm_password) {
            if (strlen($new_password) >= 8) { // Ensure password is at least 8 characters
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password = ? WHERE user_id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "si", $hashed_password, $_SESSION['user_id']);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<script>alert('Password changed successfully!');</script>";
                } else {
                    echo "<script>alert('Error updating password.');</script>";
                }
            } else {
                echo "<script>alert('Password must be at least 8 characters long.');</script>";
            }
        } else {
            echo "<script>alert('New password and confirm password do not match.');</script>";
        }
    } else {
        echo "<script>alert('Old password is incorrect.');</script>";
    }
}

// Fetch user data from the database
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result); // Fetch the user data

?>

    <!-- ...:::: Start Breadcrumb Section:::... -->
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">My Account</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="index.php">Shop</a></li>
                                    <li class="active" aria-current="page">My Account</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- ...:::: Start Account Dashboard Section:::... -->
    <div class="account-dashboard">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <!-- Nav tabs -->
                    <div class="dashboard_tab_button" data-aos="fade-up" data-aos-delay="0">
                        <ul role="tablist" class="nav flex-column dashboard-list">
                            <li><a href="#account-details" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover ">Account details</a></li>
                            <li><a href="#address" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover">Addresses</a></li>
                            <li><a href="#orders" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover">Orders</a></li>
                            <li><a href="#change_password" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover ">Change Password</a></li>
                            <li><a href="#downloads" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover">Downloads</a></li>
                            <li><a href="log_out.php" class="nav-link btn btn-block btn-md btn-black-default-hover">Logout</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 col-lg-9">
                    <!-- Tab panes -->
                    <div class="tab-content dashboard_content" data-aos="fade-up" data-aos-delay="200">
                        <div class="tab-pane fade show active" id="dashboard">
                            <h4>Dashboard</h4>
                            <p>From your account dashboard, you can easily check &amp; view your <a href="#">recent orders</a>, manage your <a href="#">shipping and billing addresses</a>, and <a href="#">edit your password and account details</a>.</p>
                        </div>

                        <!-- Address Tab -->
                        <div class="tab-pane fade" id="address">
                            <h3>Address Details</h3>
                            <div class="login">
                                <div class="login_form_container">
                                    <div class="account_login_form">
                                        <div class="row">
                                            <!-- Primary Address Card -->
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3>Primary Address Details</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <form action="#" method="post">
                                                            <div class="default-form-box mb-20">
                                                                <label>Address</label>
                                                                <input type="text" name="address" value="<?php echo $row['address']; ?>">
                                                            </div>
                                                            <div class="default-form-box mb-20">
                                                                <label>City</label>
                                                                <input type="text" name="city" value="<?php echo $row['city']; ?>">
                                                            </div>
                                                            <div class="default-form-box mb-20">
                                                                <label>State</label>
                                                                <input type="text" name="state" value="<?php echo $row['state']; ?>">
                                                            </div>
                                                            <div class="default-form-box mb-20">
                                                                <label>Country</label>
                                                                <input type="text" name="country" value="<?php echo $row['country']; ?>">
                                                            </div>
                                                            <div class="default-form-box mb-20">
                                                                <label>Pincode</label>
                                                                <input type="text" name="pincode" value="<?php echo $row['pincode']; ?>">
                                                            </div>
                                                            <div class="save_button mt-3">
                                                                <button class="btn btn-md btn-black-default-hover" type="submit" name="submit1">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Secondary Address Card -->
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3>Secondary Address Details</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <form action="#" method="post">
                                                            <div class="default-form-box mb-20">
                                                                <label>Address</label>
                                                                <input type="text" name="address2" value="<?php echo $row['address2']; ?>">
                                                            </div>
                                                            <div class="default-form-box mb-20">
                                                                <label>City</label>
                                                                <input type="text" name="city2" value="<?php echo $row['city2']; ?>">
                                                            </div>
                                                            <div class="default-form-box mb-20">
                                                                <label>State</label>
                                                                <input type="text" name="state2" value="<?php echo $row['state2']; ?>">
                                                            </div>
                                                            <div class="default-form-box mb-20">
                                                                <label>Country</label>
                                                                <input type="text" name="country2" value="<?php echo $row['country2']; ?>">
                                                            </div>
                                                            <div class="default-form-box mb-20">
                                                                <label>Pincode</label>
                                                                <input type="text" name="pincode2" value="<?php echo $row['pincode2']; ?>">
                                                            </div>
                                                            <div class="save_button mt-3">
                                                                <button class="btn btn-md btn-black-default-hover" type="submit" name="submit2">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Account Details Tab -->
                        <div class="tab-pane fade" id="account-details">
                            <h3>Account Details</h3>
                            <div class="login">
                                <div class="login_form_container">
                                    <div class="account_login_form">
                                        <form action="#" method="post">
                                            <div class="default-form-box mb-20">
                                                <label>First Name</label>
                                                <input type="text" name="firstname" value="<?php echo $row['firstname']; ?>">
                                            </div>
                                            <div class="default-form-box mb-20">
                                                <label>Last Name</label>
                                                <input type="text" name="lastname" value="<?php echo $row['lastname']; ?>">
                                            </div>
                                            <div class="default-form-box mb-20">
                                                <label>Email</label>
                                                <input type="text" name="email" value="<?php echo $row['email']; ?>" disabled>
                                            </div>
                                            <div class="default-form-box mb-20">
                                                <label>Phone Number</label>
                                                <input type="text" name="phone" value="<?php echo $row['phone']; ?>" disabled>
                                            </div>
                                            <div class="save_button mt-3">
                                                <button class="btn btn-md btn-black-default-hover" type="submit" name="submit">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Change-Password Tab -->
                        <div class="tab-pane fade" id="change_password">
                            <h3>Change Password</h3>
                            <div class="login">
                                <div class="login_form_container">
                                    <div class="account_login_form">
                                        <form action="#" method="post">
                                            <!-- Old Password Field -->
                                            <div class="default-form-box mb-20">
                                                <label>Old Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Old Password" value="" required>
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="old_password" >
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- New Password Field -->
                                            <div class="default-form-box mb-20">
                                                <label>New Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password" required>
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Confirm New Password Field -->
                                            <div class="default-form-box mb-20">
                                                <label>Confirm New Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm New Password" required>
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Save Button -->
                                            <div class="save_button mt-3">
                                                <button class="btn btn-md btn-black-default-hover" type="submit" name="password">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                } else {
                    echo "<p>No user data found.</p>";
                }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ...:::: End Account Dashboard Section:::... -->


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-password');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        this.innerHTML = '<i class="fa fa-eye-slash"></i>'; // Change icon to "eye-slash"
                    } else {
                        passwordInput.type = 'password';
                        this.innerHTML = '<i class="fa fa-eye"></i>'; // Change icon back to "eye"
                    }
                });
            });
        });
    </script>

    <?php include "include/footer.php"; ?>