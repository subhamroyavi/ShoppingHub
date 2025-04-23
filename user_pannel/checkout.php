<?php
include "include/header.php";
include "include/connection.php";

if (empty($_SESSION['user_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

// Get cart items for current user
$user_id = $_SESSION['user_id'];
$cart_query = "SELECT ci.*, p.name, p.price, p.id 
               FROM cart_items ci
               JOIN carts c ON ci.cart_id = c.id
               JOIN products p ON ci.product_id = p.id
               WHERE c.user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_query);

$subtotal = 0;
$cart_items = [];
while ($row = mysqli_fetch_assoc($cart_result)) {
    $row['subtotal'] = $row['price'] * $row['qty'];
    $subtotal += $row['subtotal'];
    $cart_items[] = $row;
}

$shipping_fee = 5.00; // Fixed shipping fee
$total = $subtotal + $shipping_fee;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    // 1. Prepare shipping address
    $name = implode(' ', array_filter([
        $_POST['firstname'],
        $_POST['lastname'],
    ]));
    $shipping_address = implode(', ', array_filter([
        $_POST['address'],
        $_POST['city'],
        $_POST['state'],
        $_POST['country'],
        $_POST['pincode'],
        $_POST['phone'],
        $_POST['email'],
    ]));

    $shipping_address = mysqli_real_escape_string($conn, $shipping_address);
    $username = mysqli_real_escape_string($conn, $name);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

    $order_query = "INSERT INTO orders (user_id, total_amount, status, payment_status, name, shipping_address)
               VALUES ($user_id, $total, 'pending', 'unpaid', '$username', '$shipping_address')";
    if (!mysqli_query($conn, $order_query)) {
        die("Order creation failed: " . mysqli_error($conn));
    }
    $order_id = mysqli_insert_id($conn);

    foreach ($cart_items as $item) {
        $insert_item = "INSERT INTO order_items (order_id, product_id, quantity, unit_price, subtotal)
                   VALUES ($order_id, {$item['product_id']}, {$item['qty']}, {$item['price']}, {$item['subtotal']})";
        if (!mysqli_query($conn, $insert_item)) {
            die("Order item insertion failed: " . mysqli_error($conn));
        }
    }

    if ($payment_method == 'cod') {
        $payment_query = "INSERT INTO payments (order_id, amount, payment_method, status)
                 VALUES ($order_id, $total, '$payment_method', 'pending')";
    } else {
        $payment_query = "INSERT INTO payments (order_id, amount, payment_method, status)
                 VALUES ($order_id, $total, '$payment_method', 'complete')";
    }

    if (!mysqli_query($conn, $payment_query)) {
        die("Payment processing failed: " . mysqli_error($conn));
    }

    $clear_cart = "DELETE ci FROM cart_items ci
              JOIN carts c ON ci.cart_id = c.id
              WHERE c.user_id = $user_id";
    if (!mysqli_query($conn, $clear_cart)) {
        die("Cart clearing failed: " . mysqli_error($conn));
    }

    echo "<script>window.location.href='order_confirmation.php?order_id=$order_id';</script>";
    exit();
}
?>

<!-- ... [rest of your HTML remains the same] ... -->

<!-- ...:::: Start Breadcrumb Section:::... -->
<div class="breadcrumb-section breadcrumb-bg-color--golden">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="breadcrumb-title">Cart</h3>
                    <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                        <nav aria-label="breadcrumb">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li class="active" aria-current="page">Cart</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Breadcrumb Section:::... -->

<!-- ...:::: Start Checkout Section:::... -->
<div class="checkout-section">
    <div class="container">
        <div class="row">
            <!-- User Quick Action Form -->
            <div class="col-12">

            </div>
            <!-- User Quick Action Form -->
        </div>
        <!-- Start User Details Checkout Form -->
        <div class="checkout_form" data-aos="fade-up" data-aos-delay="400">
            <form method="post">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <?php
                        // Fetch user data from the database
                        $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                        ?>
                            <h3>Billing Details</h3>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="default-form-box">
                                        <label>First Name <span>*</span></label>
                                        <input type="text" value="<?php echo $row['firstname']; ?>" name="firstname" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="default-form-box">
                                        <label>Last Name <span>*</span></label>
                                        <input type="text" value="<?php echo $row['lastname']; ?>" name="lastname" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="default-form-box">
                                        <label>Address</label>
                                        <input type="text" name="address" value="<?php echo $row['address']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="default-form-box">
                                        <label>City</label>
                                        <input type="text" name="city" value="<?php echo $row['city']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="default-form-box">
                                        <label>State</label>
                                        <input type="text" name="state" value="<?php echo $row['state']; ?>" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="default-form-box">
                                        <label>Country</label>
                                        <input type="text" name="country" value="<?php echo $row['country']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="default-form-box">
                                        <label>Pincode</label>
                                        <input type="text" name="pincode" value="<?php echo $row['pincode']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="default-form-box">
                                        <label>Phone<span>*</span></label>
                                        <input type="text" value="<?php echo $row['phone']; ?>" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="default-form-box">
                                        <label> Email Address <span>*</span></label>
                                        <input type="text" value="<?php echo $row['email']; ?>" name="email" required>
                                    </div>
                                </div>

                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <!-- ... [order summary section] ... -->
                        <h3>Your Order</h3>
                        <div class="order_table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_items as $item): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item['name']) ?> <strong> × <?= $item['qty'] ?></strong></td>
                                            <td>$<?= number_format($item['subtotal'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Cart Subtotal</th>
                                        <td>$<?= number_format($subtotal, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td><strong>$<?= number_format($shipping_fee, 2) ?></strong></td>
                                    </tr>
                                    <tr class="order_total">
                                        <th>Order Total</th>
                                        <td><strong>$<?= number_format($total, 2) ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="payment_method">
                            <div class="panel-default">
                                <label class="checkbox-default">
                                    <input type="radio" name="payment_method" value="credit_card" checked>
                                    <span>Credit Card</span>
                                </label>
                            </div>
                            <div class="panel-default">
                                <label class="checkbox-default">
                                    <input type="radio" name="payment_method" value="paypal">
                                    <span>PayPal</span>
                                </label>
                            </div>
                            <div class="panel-default">
                                <label class="checkbox-default">
                                    <input type="radio" name="payment_method" value="cod">
                                    <span>Cash on Delivery</span>
                                </label>
                            </div>

                            <div class="order_button pt-3">
                                <button class="btn btn-md btn-black-default-hover" type="submit" name="place_order">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> <!-- Start User Details Checkout Form -->


<?php include "include/footer.php"; ?>