<?php
//ini_set('display_errors', 1);
include './header.php';

// Check if the search query is set
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];



    $sql = "SELECT * FROM product WHERE name LIKE '%$searchQuery%'";

    $result = $db->query($sql);


    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }


} else {

    header("Location: index.php");
    exit();
}
?>

<!-- Product -->
<div class="bg0 m-t-23 p-b-140">
    <div class="container">


        <h3 class="mt-3">Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h3>
        <?php if (empty($products)): ?>
            <p>No results found.</p>
        <?php else: ?>
            <div class="row isotope-grid mt-5">
                <?php foreach ($products as $product): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
                        <div class="product-card shadow-sm">
                            <!-- Product Image -->
                            <div class="product-image position-relative">
                                <?php
                                // Extract the front image filename
                                $front_image = explode('/', $product['image1'])[4];
                                ?>
                                <a href="product-details.php?id=<?php echo $product['id'] ?>">
                                    <img src="./admin/uploaded-files/product/<?php echo $front_image ?>" alt="IMG-PRODUCT"
                                        class="img-fluid">
                                </a>
                                <div class="product-labels">
                                    <!-- You can add badges here -->
                                    <span class="badge badge-success">10% OFF</span>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="product-info p-3">
                                <a href="product-details.php?id=<?php echo $product['id'] ?>" class="product-name js-name-detail">
                                    <?php echo $product['name'] ?>
                                </a>
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Product Price -->
                                    <span class="product-price text-danger">
                                        ₹<span id="price-<?php echo $product['id'] ?>" class="price-amount"
                                            data-price="<?php echo $product['sell_price'] ?>"><?php echo $product['sell_price'] ?></span>
                                    </span>
                                    <!-- Wishlist Button
                <a href="#" class="wishlist-btn" data-toggle="tooltip" data-placement="top" title="Add to Wishlist">
                    <i class="fas fa-heart"></i>
                </a> -->
                                </div>

                                <!-- Quantity Dropdown and Add to Cart Button -->
                                <div class="cart-controls mt-3">
                                    <div class="quantity-dropdown">
                                        <select id="qty" class="form-control quantity-select num-product" name="num-product">
                                            <option value="1">1 Kg</option>
                                            <option value="2">2 Kg</option>
                                            <option value="3">3 Kg</option>

                                        </select>
                                    </div>
                                    <a href="javascript:void(0)" onclick="manage_cart('<?php echo $product['id'] ?>','add')"
                                        class="btn btn-success mt-3 w-100 js-addcart-detail">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>


<?php include './footer.php'; ?>