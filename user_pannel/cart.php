<?php

use LDAP\Result;

include "include/header.php";
include "include/connection.php";

if (empty($_SESSION['user_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

// $_GET['pid'];

if (isset($_GET['pid'])) {
    $id = $_GET['pid'];
    $user_id = $_SESSION['user_id'];

    $query = "SELECT id FROM carts WHERE user_id = '$user_id' ORDER BY created_at DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $cart_id = $row['id'];
    } else {
        $query = "INSERT INTO carts(user_id) VALUES ('$user_id')";
        $result = mysqli_query($conn, $query);
        $cart_id = mysqli_insert_id($conn);
    }

    $check_sql = mysqli_query($conn, "SELECT * FROM cart_items WHERE product_id = '$id'");
    if (mysqli_num_rows($check_sql) == 0) {
        $query = "INSERT INTO cart_items(cart_id, product_id) VALUES ('$cart_id', '$id')";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "<script>alert('Failed to add product to cart.');</script>";
        }
    }
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // $result = mysqli_query($conn, "SELECT id FROM carts WHERE user_id = '" . mysqli_real_escape_string($conn, $user_id) . "'");
    $result = mysqli_query($conn, "SELECT id FROM carts WHERE user_id = '$user_id'");

    if ($cart = mysqli_fetch_assoc($result)) {
        $cart_id = $cart['id'];
        $cart_items = mysqli_query($conn, "SELECT * FROM cart_items
                                            JOIN products on cart_items.product_id = products.id
                                            WHERE cart_items.cart_id = '$cart_id' ORDER BY cart_items.id DESC
                                           ");




        echo "</pre>"; // Close the pre tag
    }
}

?>
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


<!-- ...:::: Start Cart Section:::... -->
<div class="cart-section">
    <!-- Start Cart Table -->
    <div class="cart-table-wrapper" data-aos="fade-up" data-aos-delay="0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table_desc">
                        <div class="table_page table-responsive">
                            <table>
                                <!-- Start Cart Table Head -->
                                <thead>
                                    <tr>
                                        <th class="product_remove">Delete</th>
                                        <th class="product_thumb">Image</th>
                                        <th class="product_name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product_quantity">Quantity</th>
                                        <th class="product_total">Total</th>
                                    </tr>
                                </thead> <!-- End Cart Table Head -->
                                <tbody>
                                    <!-- Start Cart Single Item-->
                                    <?php while ($cart_details = mysqli_fetch_assoc($cart_items)) {
                                        // echo '<pre>';
                                        // print_r($cart_details);

                                    ?>


                                        <tr>
                                            <td class="product_remove"><a href="cart_itemDelete.php?id=<?php echo $cart_details['id']; ?>"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                            <td class="product_thumb"><a href="productDetails.php?id=<?php echo $cart_details['id']; ?>"><img
                                                        src="../admin/<?php echo $cart_details['image'] ?>"
                                                        alt=""></a></td>
                                            <td class="product_name"><a href="productDetails.php?id=<?php echo $cart_details['id']; ?>"><?php echo $cart_details['name'] ?></a></td>
                                            <td class="product-price"><?= $cart_details['price']; ?></td>
                                            <td class="product_quantity"><label><?php $cart_details['qty']; ?></label> <input min="1"
                                                    max="100" value="1" type="number"><?php $cart_details['price']; ?></td>
                                            <td class="product_total"><?php echo $cart_details['qty'] * $cart_details['price']; ?></td>
                                        </tr> <!-- End Cart Single Item-->

                                    <?php

                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="cart_submit">
                            <button class="btn btn-md btn-golden" type="submit">update cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Cart Table -->

    <!-- Start Coupon Start -->
    <div class="coupon_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="coupon_code left" data-aos="fade-up" data-aos-delay="200">
                        <h3>Coupon</h3>
                        <div class="coupon_inner">
                            <p>Enter your coupon code if you have one.</p>
                            <input class="mb-2" placeholder="Coupon code" type="text">
                            <button type="submit" class="btn btn-md btn-golden">Apply coupon</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="coupon_code right" data-aos="fade-up" data-aos-delay="400">
                        <h3>Cart Totals</h3>
                        <div class="coupon_inner">
                            <div class="cart_subtotal">
                                <p>Subtotal</p>
                                <p class="cart_amount">$215.00</p>
                            </div>
                            <div class="cart_subtotal ">
                                <p>Shipping</p>
                                <p class="cart_amount"><span>Flat Rate:</span> $255.00</p>
                            </div>
                            <a href="#">Calculate shipping</a>

                            <div class="cart_subtotal">
                                <p>Total</p>
                                <p class="cart_amount">$215.00</p>
                            </div>
                            <div class="checkout_btn">
                                <a href="#" class="btn btn-md btn-golden">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Coupon Start -->
</div> <!-- ...:::: End Cart Section:::... -->


<?php include "include/footer.php" ?>