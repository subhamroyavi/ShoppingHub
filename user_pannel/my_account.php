<?php
include "include/header.php";
include "include/connection.php";

// Redirect if not logged in
if (empty($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Function to safely handle user input
function sanitizeInput($conn, $input)
{
    return !empty($input) ? mysqli_real_escape_string($conn, trim($input)) : NULL;
}

// Update account details
if (isset($_POST['submit'])) {
    $firstname = sanitizeInput($conn, $_POST['firstname']);
    $lastname = sanitizeInput($conn, $_POST['lastname']);

    $stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $firstname, $lastname, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Account details updated successfully!';
    } else {
        $_SESSION['error_message'] = 'Error updating account details: ' . $stmt->error;
    }
    $stmt->close();

    echo "<script>window.location.href='my_account.php';</script>";
    exit();
}    

// Update primary address
if (isset($_POST['submit1'])) {
    $address = sanitizeInput($conn, $_POST['address']);
    $city = sanitizeInput($conn, $_POST['city']);
    $state = sanitizeInput($conn, $_POST['state']);
    $country = sanitizeInput($conn, $_POST['country']);
    $pincode = sanitizeInput($conn, $_POST['pincode']);

    $stmt = $conn->prepare("UPDATE users SET address = ?, city = ?, state = ?, country = ?, pincode = ? WHERE user_id = ?");
    $stmt->bind_param("sssssi", $address, $city, $state, $country, $pincode, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Primary address updated successfully!';
    } else {
        $_SESSION['error_message'] = 'Error updating address: ' . $stmt->error;
    }
    $stmt->close();

    echo "<script>window.location.href='my_account.php';</script>";
    exit();
}

// Update secondary address
if (isset($_POST['submit2'])) {
    $address2 = sanitizeInput($conn, $_POST['address2']);
    $city2 = sanitizeInput($conn, $_POST['city2']);
    $state2 = sanitizeInput($conn, $_POST['state2']);
    $country2 = sanitizeInput($conn, $_POST['country2']);
    $pincode2 = sanitizeInput($conn, $_POST['pincode2']);

    $stmt = $conn->prepare("UPDATE users SET address2 = ?, city2 = ?, state2 = ?, country2 = ?, pincode2 = ? WHERE user_id = ?");
    $stmt->bind_param("sssssi", $address2, $city2, $state2, $country2, $pincode2, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Secondary address updated successfully!';
    } else {
        $_SESSION['error_message'] = 'Error updating address: ' . $stmt->error;
    }
    $stmt->close();
    // header("Location: my_account.php#address");
    echo "<script>window.location.href='my_account.php';</script>";

    exit();
}

// Change password
if (isset($_POST['password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password strength
    if (strlen($new_password) < 8) {
        $_SESSION['error_message'] = 'Password must be at least 8 characters long.';
        header("Location: my_account.php#change_password");
        exit();
    }

    if ($new_password !== $confirm_password) {
        $_SESSION['error_message'] = 'New passwords do not match.';
        header("Location: my_account.php#change_password");
        exit();
    }

    // Get current password hash
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user || !password_verify($old_password, $user['password'])) {
        $_SESSION['error_message'] = 'Current password is incorrect.';
        header("Location: my_account.php#change_password");
        exit();
    }

    // Update password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Password changed successfully!';
    } else {
        $_SESSION['error_message'] = 'Error changing password: ' . $stmt->error;
    }
    $stmt->close();
    header("Location: my_account.php#change_password");
    exit();
}

// Get user data
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    die("User not found.");
}

// Get user orders
$orders = [];
$stmt = $conn->prepare("SELECT order_id, created_at, total_amount, status FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
$stmt->close();
?>

<!-- Display success/error messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<!-- Breadcrumb Section -->
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
                                <li class="active" aria-current="page">My Account</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Account Dashboard Section -->
<div class="account-dashboard">
    <div class="container">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-sm-12 col-md-3 col-lg-3">
                <div class="dashboard_tab_button" data-aos="fade-up" data-aos-delay="0">
                    <ul role="tablist" class="nav flex-column dashboard-list">
                        <li><a href="#dashboard" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover active">Dashboard</a></li>
                        <li><a href="#account-details" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover">Account Details</a></li>
                        <li><a href="#address" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover">Addresses</a></li>
                        <li><a href="#orders" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover">Orders</a></li>
                        <li><a href="#change_password" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover">Change Password</a></li>
                        <li><a href="log_out.php" class="nav-link btn btn-block btn-md btn-black-default-hover">Logout</a></li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-sm-12 col-md-9 col-lg-9">
                <div class="tab-content dashboard_content" data-aos="fade-up" data-aos-delay="200">
                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active" id="dashboard">
                        <h4>Welcome, <?= htmlspecialchars($user['firstname']) ?>!</h4>
                        <p>From your account dashboard, you can:</p>
                        <ul>
                            <li>View and edit your <a href="" class="text-primary">account details</a></li>
                            <li>Manage your <a href="" class="text-primary">shipping addresses</a></li>
                            <li>Track your <a href="order-tracking.php" class="text-primary">recent orders</a></li>
                            <li><a href="" class="text-primary">Change your password</a></li>
                        </ul>
                    </div>

                    <!-- Account Details Tab -->
                    <div class="tab-pane fade" id="account-details">
                        <h3>Account Details</h3>
                        <div class="login">
                            <div class="login_form_container">
                                <div class="account_login_form">
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="default-form-box mb-20">
                                                    <label>First Name <span class="required">*</span></label>
                                                    <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="default-form-box mb-20">
                                                    <label>Last Name <span class="required">*</span></label>
                                                    <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="default-form-box mb-20">
                                            <label>Email Address</label>
                                            <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                                        </div>
                                        <div class="default-form-box mb-20">
                                            <label>Phone Number</label>
                                            <input type="text" value="<?= htmlspecialchars($user['phone']) ?>" disabled>
                                        </div>
                                        <div class="save_button mt-3">
                                            <button class="btn btn-md btn-black-default-hover" type="submit" name="submit">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Tab -->
                    <div class="tab-pane fade" id="address">
                        <h3>Address Details</h3>
                        <div class="login">
                            <div class="row">
                                <!-- Primary Address -->
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h4 class="mb-0">Primary Address</h4>
                                        </div>
                                        <div class="card-body">
                                            <form method="post">
                                                <div class="default-form-box mb-20">
                                                    <label>Address</label>
                                                    <input type="text" name="address" value="<?= htmlspecialchars($user['address']) ?>">
                                                </div>
                                                <div class="default-form-box mb-20">
                                                    <label>City</label>
                                                    <input type="text" name="city" value="<?= htmlspecialchars($user['city']) ?>">
                                                </div>
                                                <div class="default-form-box mb-20">
                                                    <label>State/Province</label>
                                                    <input type="text" name="state" value="<?= htmlspecialchars($user['state']) ?>">
                                                </div>
                                                <div class="default-form-box mb-20">
                                                    <label>Country</label>
                                                    <input type="text" name="country" value="<?= htmlspecialchars($user['country']) ?>">
                                                </div>
                                                <div class="default-form-box mb-20">
                                                    <label>Postal Code</label>
                                                    <input type="text" name="pincode" value="<?= htmlspecialchars($user['pincode']) ?>">
                                                </div>
                                                <div class="save_button mt-3">
                                                    <button class="btn btn-md btn-black-default-hover" type="submit" name="submit1">Update Address</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Secondary Address -->
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h4 class="mb-0">Secondary Address</h4>
                                        </div>
                                        <div class="card-body">
                                            <form method="post">
                                                <div class="default-form-box mb-20">
                                                    <label>Address</label>
                                                    <input type="text" name="address2" value="<?= htmlspecialchars($user['address2']) ?>">
                                                </div>
                                                <div class="default-form-box mb-20">
                                                    <label>City</label>
                                                    <input type="text" name="city2" value="<?= htmlspecialchars($user['city2']) ?>">
                                                </div>
                                                <div class="default-form-box mb-20">
                                                    <label>State/Province</label>
                                                    <input type="text" name="state2" value="<?= htmlspecialchars($user['state2']) ?>">
                                                </div>
                                                <div class="default-form-box mb-20">
                                                    <label>Country</label>
                                                    <input type="text" name="country2" value="<?= htmlspecialchars($user['country2']) ?>">
                                                </div>
                                                <div class="default-form-box mb-20">
                                                    <label>Postal Code</label>
                                                    <input type="text" name="pincode2" value="<?= htmlspecialchars($user['pincode2']) ?>">
                                                </div>
                                                <div class="save_button mt-3">
                                                    <button class="btn btn-md btn-black-default-hover" type="submit" name="submit2">Update Address</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Tab -->
                    <div class="tab-pane fade" id="orders">
                        <h3>Your Orders</h3>
                        <?php if (empty($orders)): ?>
                            <div class="alert alert-info">
                                <p>You haven't placed any orders yet.</p>
                                <a href="shop.php" class="btn btn-black-default-hover">Start Shopping</a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><?= $order['order_id'] ?></td>
                                                <td><?= date('M j, Y', strtotime($order['created_at'])) ?></td>
                                                <td>
                                                    <span class="badge 
                                                        <?= $order['status'] == 'completed' ? 'bg-success' : ($order['status'] == 'processing' ? 'bg-primary' : ($order['status'] == 'cancelled' ? 'bg-danger' : 'bg-secondary')) ?>">
                                                        <?= ucfirst($order['status']) ?>
                                                    </span>
                                                </td>
                                                <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                                <td>
                                                    <a href="order-tracking.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-outline-dark">View</a>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Change Password Tab -->
                    <div class="tab-pane fade" id="change_password">
                        <h3>Change Password</h3>
                        <div class="login">
                            <div class="login_form_container">
                                <div class="account_login_form">
                                    <form method="post">
                                        <div class="default-form-box mb-20">
                                            <label>Current Password <span class="required">*</span></label>
                                            <div class="input-group">
                                                <input type="password" name="old_password" id="old_password" class="form-control" required>
                                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="old_password">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="default-form-box mb-20">
                                            <label>New Password <span class="required">*</span></label>
                                            <div class="input-group">
                                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                            <small class="form-text text-muted">Minimum 8 characters</small>
                                        </div>
                                        <div class="default-form-box mb-20">
                                            <label>Confirm New Password <span class="required">*</span></label>
                                            <div class="input-group">
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="confirm_password">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="save_button mt-3">
                                            <button class="btn btn-md btn-black-default-hover" type="submit" name="password">Change Password</button>
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const target = document.getElementById(this.getAttribute('data-target'));
                const icon = this.querySelector('i');

                if (target.type === 'password') {
                    target.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    target.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });

        // Activate tab from URL hash
        const hash = window.location.hash;
        if (hash) {
            const tab = document.querySelector(`.nav-link[href="${hash}"]`);
            if (tab) {
                tab.click();
            }
        }
    });
</script>

<?php include "include/footer.php"; ?>