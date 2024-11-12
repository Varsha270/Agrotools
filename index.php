<?php
include './header.php';



//$db = Database::getInstance();


$products = [];

//$sql = "SELECT * FROM product ORDER BY id DESC";
$sql = "SELECT product.*, IFNULL(AVG(reviews.rating), 0) as avg_rating 
          FROM product 
          LEFT JOIN reviews ON product.id = reviews.product_id 
          GROUP BY product.id";
//echo $sql;die;
$res = $db->query($sql);

while ($row = $res->fetch_object()) {
    $products[] = $row;
}

//print_r($products);die;

?>


<!-- Slider -->
<section class="section-slide">
    <div class="wrap-slick1">
        <div class="slick1">
            <div class="item-slick1" style="background-image: url(images/bg789.jpg);">
                <div class="container h-full">
                    <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                        <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">

                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">

                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">

                        </div>
                    </div>
                </div>
            </div>

            <div class="item-slick1" style="background-image: url(images/bg66.jpeg);">
                <div class="container h-full">
                    <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                        <div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">

                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">

                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">

                        </div>
                    </div>
                </div>
            </div>

            <div class="item-slick1" style="background-image: url(images/1111.png);">
                <div class="container h-full">
                    <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                        <div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">

                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">

                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="">
    <div id="google_element"></div>
</div>
<!-- Banner -->
<div class="sec-banner bg0 p-t-80 p-b-50">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
                <!-- Block1 -->
                <div class="block1 wrap-pic-w">
                    <img src="images/12345.webp" alt="IMG-BANNER">

                    <a href="#" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
                            <span class="block1-name ltext-102 trans-04 p-b-8">
                                Agri-Rentals
                            </span>

                            <span class="block1-info stext-102 trans-04">
                                SUCCESS IN AGRICULTURE
                            </span>
                        </div>

                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Buy Now
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
                <!-- Block1 -->
                <div class="block1 wrap-pic-w">
                    <img src="images/123.jpeg" alt="IMG-BANNER">

                    <a href="#" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
                            <span class="block1-name ltext-102 trans-04 p-b-8">

                            </span>

                            <span class="block1-info stext-102 trans-04">

                            </span>
                        </div>

                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Buy Now
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
                <!-- Block1 -->
                <div class="block1 wrap-pic-w">
                    <img src="images/kk.jpeg" alt="IMG-BANNER">

                    <a href="#" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
                            <span class="block1-name ltext-102 trans-04 p-b-8">
                                AFFORDABLE PRICE
                            </span>

                            <span class="block1-info stext-102 trans-04">
                                WE CARE FOR YOU!!!
                            </span>
                        </div>

                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Buy Now
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>




<?php include './footer.php'; ?>
<script>
    $(document).ready(function () {
        // Listen for changes in the quantity dropdown
        $('.quantity-select').on('change', function () {
            var productId = $(this).closest('.product-info').find('.js-addcart-detail').attr('onclick').match(/\d+/)[0];
            var quantity = $(this).val(); // Get the selected quantity
            var priceElement = $('#price-' + productId); // Get the price element by ID
            var basePrice = priceElement.data('price'); // Get the base price stored in the data attribute

            // Calculate the new price based on the selected quantity
            var newPrice = basePrice * quantity;

            // Update the displayed price
            priceElement.text(newPrice.toFixed(2));
        });
    });

</script>

<script src="https://translate.google.com/translate_a/element.js?cb=loadGoogleTranslate">
</script>
<script>
    function loadGoogleTranslate() {
        new google.translate.TranslateElement("google_element");
    }
</script>