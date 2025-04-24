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
                        <h3 class="breadcrumb-title">Contact Us</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li class="active" aria-current="page">Contact Us</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- ...::::Start Map Section:::... -->
    <div class="map-section" data-aos="fade-up" data-aos-delay="0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="mapouter">
                        <div class="gmap_canvas">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3582.0468740088168!2d89.464411!3d26.130014600000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e2e1599db70899%3A0x1ea5f4a6a0b48a35!2sSitala%20Bari%20Rd%2C%20Dinhata%2C%20West%20Bengal%20736135!5e0!3m2!1sen!2sin!4v1745422616716!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...::::End  Map Section:::... -->

    <!-- ...::::Start Contact Section:::... -->
    <div class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Start Contact Details -->
                    <div class="contact-details-wrapper section-top-gap-100" data-aos="fade-up" data-aos-delay="0">
                        <div class="contact-details">
                            <!-- Start Contact Details Single Item -->
                            <div class="contact-details-single-item">
                                <div class="contact-details-icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="contact-details-content contact-phone">
                                    <a href="tel:+0123456789">0123456789</a>
                                    <a href="tel:+0123456789">0123456789</a>
                                </div>
                            </div> <!-- End Contact Details Single Item -->
                            <!-- Start Contact Details Single Item -->
                            <div class="contact-details-single-item">
                                <div class="contact-details-icon">
                                    <i class="fa fa-globe"></i>
                                </div>
                                <div class="contact-details-content contact-phone">
                                    <a href="mailto:shoppinghub@gmail.com">shoppinghub@gmail.com</a>
                                    <a href="http://www.shoppinghub.com/">www.shoppinghub.com</a>
                                </div>
                            </div> <!-- End Contact Details Single Item -->
                            <!-- Start Contact Details Single Item -->
                            <div class="contact-details-single-item">
                                <div class="contact-details-icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="contact-details-content contact-phone">
                                    <span>Your address goes here.</span>
                                </div>
                            </div> <!-- End Contact Details Single Item -->
                        </div>
                        <!-- Start Contact Social Link -->
                        <div class="contact-social">
                            <h4>Follow Us</h4>
                            <ul>
                                <li><a href=""><i class="fa fa-facebook"></i></a></li>
                                <li><a href=""><i class="fa fa-twitter"></i></a></li>
                                <li><a href=""><i class="fa fa-youtube"></i></a></li>
                                <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                                <li><a href=""><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div> <!-- End Contact Social Link -->
                    </div> <!-- End Contact Details -->
                </div>
                <div class="col-lg-8">
                    <div class="contact-form section-top-gap-100" data-aos="fade-up" data-aos-delay="200">
                        <h3>Get In Touch</h3>
                        <form id="contact-form" action="https://htmlmail.hasthemes.com/nazmul/mail.php" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="default-form-box mb-20">
                                        <label for="contact-name">Name</label>
                                        <input name="name" type="text" id="contact-name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="default-form-box mb-20">
                                        <label for="contact-email">Email</label>
                                        <input name="email" type="email" id="contact-email">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="default-form-box mb-20">
                                        <label for="contact-subject">Subject</label>
                                        <input name="subject" type="text" id="contact-subject">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="default-form-box mb-20">
                                        <label for="contact-message">Your Message</label>
                                        <textarea name="message" id="contact-message" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button class="btn btn-lg btn-black-default-hover" type="submit">SEND</button>
                                </div>
                                <p class="form-messege"></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ...::::ENd Contact Section:::... -->


<?php include "include/footer.php" ?>
