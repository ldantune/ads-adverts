<!DOCTYPE html>
<html lang="en">

<head>

    <!-- SITE TITTLE -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="<?php echo csrf_token(); ?>" content="<?php echo csrf_hash(); ?>" class="csrf" />
    <title><?php echo $this->renderSection('title') ?><?php echo  ' - ' . env('APP_NAME') ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo site_url('web/'); ?>plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo site_url('web/'); ?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Owl Carousel -->
    <link href="<?php echo site_url('web/'); ?>plugins/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="<?php echo site_url('web/'); ?>plugins/slick-carousel/slick/slick-theme.css" rel="stylesheet">
    <!-- Fancy Box -->
    <link href="<?php echo site_url('web/'); ?>plugins/fancybox/jquery.fancybox.pack.css" rel="stylesheet">

    <link href="<?php echo site_url('web/'); ?>plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="<?php echo site_url('web/'); ?>plugins/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css" rel="stylesheet">
    <!-- CUSTOM CSS -->
    <link href="<?php echo site_url('web/'); ?>css/style.css" rel="stylesheet">

    <!-- FAVICON -->
    <link href="<?php echo site_url('web/'); ?>img/favicon.png" rel="shortcut icon">

    <?php echo $this->renderSection('styles'); ?>

</head>

<body class="body-wrapper">


    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg  navigation">
                        <a class="navbar-brand" href="index.html">
                            <img src="<?php echo site_url('web/'); ?>images/logo.png" alt="">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto main-nav ">
                                <li class="nav-item active">
                                    <a class="nav-link" href="<?php echo route_to('web.home') ?>">Home</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo route_to('pricing') ?>">Nossos Planos</a>
                                </li>

                                <?php if (auth()->check()) : ?>

                                    <?php if (!auth()->user()->isSuperadmin()) : ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo route_to('dashboard') ?>">Dashboard</a>
                                        </li>
                                    <?php else : ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo route_to('manager') ?>">Manager</a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <li class="nav-item dropdown dropdown-slide">
                                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Pages <span><i class="fa fa-angle-down"></i></span>
                                    </a>
                                    <!-- Dropdown list -->
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="category.html">Category</a>
                                        <a class="dropdown-item" href="single.html">Single Page</a>
                                        <a class="dropdown-item" href="store-single.html">Store Single</a>
                                        <a class="dropdown-item" href="dashboard.html">Dashboard</a>
                                        <a class="dropdown-item" href="user-profile.html">User Profile</a>
                                        <a class="dropdown-item" href="submit-coupon.html">Submit Coupon</a>
                                        <a class="dropdown-item" href="blog.html">Blog</a>
                                        <a class="dropdown-item" href="single-blog.html">Single Post</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown dropdown-slide">
                                    <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Listing <span><i class="fa fa-angle-down"></i></span>
                                    </a>
                                    <!-- Dropdown list -->
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </li>
                            </ul>
                            <ul class="navbar-nav ml-auto mt-10">
                                <?php if (!auth()->check()) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link login-button" href="<?php echo route_to('login'); ?>">Login</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link login-button" href="<?php echo route_to('register'); ?>">Registre-se</a>
                                    </li>
                                <?php else : ?>
                                    <li class="nav-item">
                                        <form method="POST" action="<?= route_to('logout') ?>">
                                            <?php echo csrf_field(); ?>
                                            <button class="nav-link login-button" type="submit">Logout</button>
                                        </form>
                                    </li>
                                <?php endif; ?>

                                <li class="nav-item">
                                    <a class="nav-link add-button" href="<?php echo route_to('dashboard') ?>"><i class="fa fa-plus-circle"></i> Criar anúncio</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!--===============================
=            Hero Area            =
================================-->

    <section class="hero-area bg-1 text-center overly">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Header Contetnt -->
                    <div class="content-block">
                        <h1>Buy & Sell Near You </h1>
                        <p>Join the millions who buy and sell from each other <br> everyday in local communities around the world</p>
                        <div class="short-popular-category-list text-center">
                            <h2>Popular Category</h2>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href=""><i class="fa fa-bed"></i> Hotel</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href=""><i class="fa fa-grav"></i> Fitness</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href=""><i class="fa fa-car"></i> Cars</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href=""><i class="fa fa-cutlery"></i> Restaurants</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href=""><i class="fa fa-coffee"></i> Cafe</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- Advance Search -->
                    <div class="advance-search">
                        <form action="#">
                            <div class="row">
                                <!-- Store Search -->
                                <div class="col-lg-6 col-md-12">
                                    <div class="block d-flex">
                                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="search" placeholder="Search for store">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="block d-flex">
                                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="search" placeholder="Search for store">
                                        <!-- Search Button -->
                                        <button class="btn btn-main">SEARCH</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
        <!-- Container End -->
    </section>

    <!--===================================
=            Client Slider            =
====================================-->
    <?php echo $this->include('Web/Layout/_session_messages'); ?>
    <!-- Page content-->
    <?php echo $this->renderSection('content') ?>

    <!--===========================================
=            Popular deals section            =
============================================-->



    <!--============================
=            Footer            =
=============================-->

    <footer class="footer section section-sm">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-7 offset-md-1 offset-lg-0">
                    <!-- About -->
                    <div class="block about">
                        <!-- footer logo -->
                        <img src="<?php echo site_url('web/'); ?>images/logo-footer.png" alt="">
                        <!-- description -->
                        <p class="alt-color">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                </div>
                <!-- Link list -->
                <div class="col-lg-2 offset-lg-1 col-md-3">
                    <div class="block">
                        <h4>Site Pages</h4>
                        <ul>
                            <li><a href="#">Boston</a></li>
                            <li><a href="#">How It works</a></li>
                            <li><a href="#">Deals & Coupons</a></li>
                            <li><a href="#">Articls & Tips</a></li>
                            <li><a href="#">Terms of Services</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Link list -->
                <div class="col-lg-2 col-md-3 offset-md-1 offset-lg-0">
                    <div class="block">
                        <h4>Admin Pages</h4>
                        <ul>
                            <li><a href="#">Boston</a></li>
                            <li><a href="#">How It works</a></li>
                            <li><a href="#">Deals & Coupons</a></li>
                            <li><a href="#">Articls & Tips</a></li>
                            <li><a href="#">Terms of Services</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Promotion -->
                <div class="col-lg-4 col-md-7">
                    <!-- App promotion -->
                    <div class="block-2 app-promotion">
                        <a href="">
                            <!-- Icon -->
                            <img src="<?php echo site_url('web/'); ?>images/footer/phone-icon.png" alt="mobile-icon">
                        </a>
                        <p>Get the Dealsy Mobile App and Save more</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container End -->
    </footer>
    <!-- Footer Bottom -->
    <footer class="footer-bottom">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-12">
                    <!-- Copyright -->
                    <div class="copyright">
                        <p>Copyright © 2016. All Rights Reserved</p>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <!-- Social Icons -->
                    <ul class="social-media-icons text-right">
                        <li><a class="fa fa-facebook" href=""></a></li>
                        <li><a class="fa fa-twitter" href=""></a></li>
                        <li><a class="fa fa-pinterest-p" href=""></a></li>
                        <li><a class="fa fa-vimeo" href=""></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Container End -->
        <!-- To Top -->
        <div class="top-to">
            <a id="top" class="" href=""><i class="fa fa-angle-up"></i></a>
        </div>
    </footer>

    <!-- JAVASCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="<?php echo site_url('web/'); ?>plugins/bootstrap/dist/js/popper.min.js"></script>
    <script src="<?php echo site_url('web/'); ?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo site_url('web/'); ?>plugins/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js"></script>
    <script src="<?php echo site_url('web/'); ?>plugins/slick-carousel/slick/slick.min.js"></script>

    <script src="<?php echo site_url('web/'); ?>plugins/fancybox/jquery.fancybox.pack.js"></script>
    <script src="<?php echo site_url('web/'); ?>plugins/smoothscroll/SmoothScroll.min.js"></script>
    <script src="<?php echo site_url('web/'); ?>js/scripts.js"></script>

    <script src="<?php echo site_url('manager_assets/toastr/toastr.min.js'); ?>"></script>

    <?php echo $this->renderSection('scripts'); ?>

</body>

</html>