<?php
ini_set('display_errors', 1);

require './admin/libs/database.php';
require_once './helpers/helpers.php';
require './add_to_cart.php';
//$db = Database::getInstance();
if (!isset($_SESSION)) {
    session_start();
}


$sql = "SELECT * FROM category";
//echo $sql;die;

$res = $db->query($sql);

while ($row = mysqli_fetch_object($res)) {
    $categories[] = $row;
}

$obj = new add_to_cart();
$totalProduct = $obj->totalProduct();
//unset($_SESSION['USER_LOGIN']);
//unset($_SESSION['cart']);
//echo 'cart'.$_SESSION['cart'];
//print_r($totalProduct);


?>





<!DOCTYPE html>
<html lang="en">

<head>
    <title>Agri-Rentals</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart Icon with Total Product Count</title>
        <link rel="stylesheet" href="path/to/your/css/styles.css">
        <style>
            .icon-header-item {
                position: relative;
                display: inline-block;
            }

            .htc__qua {
                position: absolute;
                top: -10px;
                /* Adjust this value as needed */
                right: -10px;
                /* Adjust this value as needed */
                background-color: #717fe0;
                /* Background color for the counter */
                color: white;
                /* Text color */
                padding: 2px 6px;
                /* Padding around the counter */
                border-radius: 50%;
                /* Make it a circle */
                font-size: 12px;
                /* Font size */
            }

            .icon-header-item .zmdi-shopping-cart {
                font-size: 24px;
                /* Adjust this value as needed */
            }

            .containers {
                background-color: white;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }

            input[type="text"] {
                padding: 10px;
                width: 200px;
                margin-bottom: 10px;
            }

            button {
                padding: 10px 20px;
                background-color: #007BFF;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            button:hover {
                background-color: #0056b3;
            }

            .product-card {
                border: 1px solid #ddd;
                background-color: #fff;
                border-radius: 8px;
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .product-card:hover {
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
                transform: translateY(-5px);
            }

            /*.product-image {
                position: relative;
                .product-image 
            }

            .product-image img {
                width: 100%;
                height: auto;
                display: block;
                border-bottom: 1px solid #ddd;
            }*/
            .product-image {
                position: relative;
                height: 250px; /* Set a fixed height for the product image container */
                overflow: hidden; /* Hide any overflowing content */
            }
            
            .product-image img {
                width: 100%; /* Make the image fill the container's width */
                height: 100%; /* Make the image fill the container's height */
                 
                border-bottom: 1px solid #ddd;
                object-fit: cover; /* Ensure the image maintains its aspect ratio and crops if necessary */
            }

            .product-labels .badge {
                position: absolute;
                top: 10px;
                left: 10px;
                font-size: 12px;
                padding: 5px 8px;
            }

            .product-info {
                padding: 15px;
                text-align: center;
            }

            .product-name {
                font-weight: bold;
                font-size: 16px;
                color: #333;
                margin-bottom: 10px;
                text-decoration: none;
            }

            .product-price {
                font-weight: bold;
                font-size: 18px;
                color: #E74C3C;
            }

            .wishlist-btn {
                color: #E74C3C;
                cursor: pointer;
            }

            .cart-controls {
                text-align: center;
            }

            .quantity-dropdown {
                width: 100%;
                max-width: 120px;
                margin: 0 auto;
            }

            .quantity-select {
                width: 100%;
                padding: 6px;
            }

            .add-to-cart-btn {
                background-color: #28a745;
                color: #fff;
                font-size: 14px;
                border-radius: 4px;
            }

            .add-to-cart-btn:hover {
                background-color: #218838;
            }

            .logo {
    font-family: 'Arial', sans-serif;
    font-size: 28px; /* Larger font size for prominence */
    font-weight: bold;
    color: #4CAF50; /* Green color for agriculture theme */
    text-decoration: none;
    padding: 10px 20px; /* Add padding for better spacing */
    border: 2px solid transparent; /* Border for hover effect */
    transition: all 0.3s ease; /* Smooth transition for hover effects */
}

.logo:hover {
    color: #388E3C; /* Darker green on hover */
    border-bottom: 2px solid #388E3C; /* Subtle underline on hover */
    transform: scale(1.05); /* Slight zoom-in effect on hover */
}
/* Ensure all images have the same height and width */
.block1 img {
    width: 100%; /* Full width for responsiveness */
    height: 300px; /* Set a uniform height */
    object-fit: cover; /* Ensures the image covers the area without distortion */
}

/* Optionally, you can also add some box-shadow or border-radius for better visual aesthetics */
.block1 {
    border-radius: 8px; /* Rounded corners */
    overflow: hidden; /* Prevents image overflow */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for better depth */
}

        </style>

    </head>

<body class="animsition" style="background-color:#b2f7f2">

    <!-- Header -->
    <header class="header-v2">
        <!-- Header desktop -->
        <div class="container-menu-desktop trans-03">
            <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop p-l-45">

                    <!-- Logo desktop -->
                    <a href="./index.php" class="logo">
                       Agri-Rentals
                    </a>

                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li class="active-menu">
                                <a href="./index.php">Home</a>

                            </li>
                            <?php
                            foreach ($categories as $category) {
                                ?>
                                <li><a
                                        href="categories.php?id=<?php echo $category->id ?>"><?php echo $category->catname ?></a>
                                </li>
                                <?php
                            }
                            ?>
                            <li>
                                <a href="blog.php">Blog</a>
                            </li>

                            <li>
                                <a href="contact.php">Contact</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Icon header -->
                    <div class="wrap-icon-header flex-w flex-r-m h-full">
                        <div class="flex-c-m h-full p-r-24">
                            <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-search">
                                <i class="zmdi zmdi-search"></i>
                            </div>
                        </div>

                        <ul class="main-menu">
                            <li class="">

                                <?php if (isset($_SESSION['USER_LOGIN'])) {
                                    echo '<a href="./logout.php">Logout</a> | <a href="./my-bookings.php">my_lendings</a>';
                                } else {
                                    echo '<a href="./login.php">User Login/Register</a>';
                                }
                                ?>

                            </li>
                            <li>
                                <a href="./admin/login.php">seller login</a>
                            </li>
                        </ul>
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11  js-show-cart">
                            <a href="./cart.php"><span class="htc__qua"><?php echo $totalProduct; ?></span></a>
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>

                        <div class="flex-c-m h-full p-lr-19">
                            <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-sidebar">
                                <i class="zmdi zmdi-menu"></i>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <a href="index.php"><img src="images/WhatsApp Image 2024-09-12 at 06.15.28_fc52ba8d.jpg"
                        alt="IMG-LOGO"></a>
            </div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">
                <div class="flex-c-m h-full p-r-10">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>
                </div>

                <div class="flex-c-m h-full p-lr-10 bor5">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-cart">
                        <a href="./cart.php"><span class="htc__qua"><?php echo $totalProduct; ?></span></a>
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                </div>
            </div>

            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>


        <!-- Menu Mobile -->
        <div class="menu-mobile">
            <ul class="main-menu-m">
                <li>
                    <a href="index.php">Home</a>

                </li>

                <?php
                foreach ($categories as $category) {
                    ?>
                    <li><a href="categories.php?id=<?php echo $category->id ?>"><?php echo $category->catname ?></a>
                    </li>
                    <?php
                }
                ?>


                <li>
                    <a href="blog.php">Blog</a>
                </li>

                <li>
                    <a href="contact.php">Contact</a>
                </li>

            </ul>
        </div>
        <!-- Modal Search -->
        <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
            <div class="container-search-header">

                <!--<h2 style="text-align:center; font-size: 24px; font-weight: bold; color: #333;">Check for Availability</h2>-->

                <!--<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search" style="position: absolute; top: 20px; right: 20px;">
            <img src="images/icons/icon-close2.png" alt="CLOSE" style="width: 20px; height: 20px;">
        </button>-->


                <div class="containers" style="padding: 40px; max-width: 400px; margin: 0 auto;">
                    <h4 style="text-align: center; font-size: 22px; color: #4CAF50;" class="mb-2">Check Service Availability</h4>

                    <form id="pincodeForm" method="POST" action="check_service.php"
                        style="display: flex; flex-direction: column; align-items: center;">
                        <input type="text" name="pincode" placeholder="Enter your pincode" required style="
                    padding: 15px; 
                    width: 100%; 
                    margin-bottom: 20px; 
                    border-radius: 8px; 
                    border: 1px solid #ccc; 
                    font-size: 16px;">

                        <button type="submit" style="
                    padding: 12px 25px; 
                    background-color: #4CAF50; 
                    color: white; 
                    border: none; 
                    border-radius: 8px; 
                    font-size: 16px; 
                    cursor: pointer; 
                    transition: background-color 0.3s;">
                            Check Availability
                        </button>
                    </form>
                </div>
            </div>
        </div>

        </div>
        </div>
      
    </header>

    <!-- Sidebar -->
    <aside class="wrap-sidebar js-sidebar">
        <div class="s-full js-hide-sidebar"></div>

        <div class="sidebar flex-col-l p-t-22 p-b-25">
            <div class="flex-r w-full p-b-30 p-r-27">
                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-sidebar">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="sidebar-content flex-w w-full p-lr-65 js-pscroll">
                <ul class="sidebar-link w-full">
                    <li class="p-b-13">
                        <a href="index.html" class="stext-102 cl2 hov-cl1 trans-04">
                            Home
                        </a>
                    </li>

                    <li class="p-b-13">
                        <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                            My Wishlist
                        </a>
                    </li>

                    <li class="p-b-13">
                        <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                            My Account
                        </a>
                    </li>

                    <li class="p-b-13">
                        <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                            Track Oder
                        </a>
                    </li>

                    <li class="p-b-13">
                        <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                            Refunds
                        </a>
                    </li>

                    <li class="p-b-13">
                        <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                            Help & FAQs
                        </a>
                    </li>
                </ul>

                <div class="sidebar-gallery w-full p-tb-30">
                    <span class="mtext-101 cl5">
                        Agri-Rentals
                    </span>

                    <div class="flex-w flex-sb p-t-36 gallery-lb">
                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/a.jpg" data-lightbox="gallery"
                                style="background-image: url('images/a.jpg');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/back_app.jpg" data-lightbox="gallery"
                                style="background-image: url('images/back_app.jpg');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/aa.png" data-lightbox="gallery"
                                style="background-image: url('images/aa.png');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/download.jpeg" data-lightbox="gallery"
                                style="background-image: url('images/download.jpeg');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/fff.webp" data-lightbox="gallery"
                                style="background-image: url('images/fff.webp');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/hhh.jpg" data-lightbox="gallery"
                                style="background-image: url('images/hhh.jpg');"></a>
                        </div>


                    </div>

                    <div class="sidebar-gallery w-full">
                        <span class="mtext-101 cl5">
                            About Us
                        </span>

                        <p class="stext-108 cl6 p-t-27">
                            We provide Tools at home door services
                        </p>
                    </div>
                </div>
            </div>
    </aside>


    <!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>

        <div class="header-cart flex-col-l p-l-65 p-r-25">
            <div class="header-cart-title flex-w flex-sb-m p-b-8">
                <span class="mtext-103 cl2">
                    Your Cart
                </span>

                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="header-cart-content flex-w js-pscroll">
                <ul class="header-cart-wrapitem w-full">
                    <?php
                    $cart_total = 0;
                    foreach ($_SESSION['cart'] as $key => $val) {
                        $productArr = get_product($db, '', '', $key);
                        $pname = $productArr[0]['name'];
                        $price = $productArr[0]['sell_price'];
                        $front_image1 = explode('/', $productArr[0]['image1'])[4];
                        $qty = $val['qty'];
                        $cart_total += ($price * $qty);
                        ?>
                        <li class="header-cart-item flex-w flex-t m-b-12">
                            <div class="header-cart-item-img">
                                <img src="./admin/uploaded-files/product/<?php echo $front_image1 ?>" alt="IMG">
                            </div>

                            <div class="header-cart-item-txt p-t-8">
                                <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                    <?php echo $pname ?>
                                </a>

                                <span class="header-cart-item-info">
                                    <?php echo $qty ?> x Rs<?php echo $price ?>
                                </span>
                            </div>
                        </li>
                    <?php } ?>
                </ul>

                <div class="w-full">
                    <div class="header-cart-total w-full p-tb-40">
                        Total: $<?php echo $cart_total ?>
                    </div>

                    <div class="header-cart-buttons flex-w w-full">
                        <a href="./cart.php"
                            class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                            View Cart
                        </a>

                        <a href="shoping-cart.html"
                            class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Check Out
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>

