<?php include './header.php';
//require './admin/libs/database.php';


//session_start();
//print_r($_SESSION['USER_LOGIN']);
ini_set('display_errors', 1);
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    ?>
    <script>
        window.location.href = './index.php';
    </script>
    <?php
}

$cart_total = 0;

if (isset($_POST['submit'])) {
    $address = get_safe_value($db, $_POST['address']);
    $city = get_safe_value($db, $_POST['city']);
    $pincode = get_safe_value($db, $_POST['pincode']);
    $payment_type = get_safe_value($db, $_POST['payment_type']);
    $user_id = $_SESSION['USER_ID'];
    foreach ($_SESSION['cart'] as $key => $val) {
        $productArr = get_product($db, '', '', $key);
        $price = $productArr[0]['sell_price'];
        $qty = $val['qty'];
        $cart_total = $cart_total + ($price * $qty);

    }
    $total_price = $cart_total;
    $payment_status = 'pending';
    if ($payment_type == 'cod') {
        $payment_status = 'success';
    }
    $order_status = '1';
    $added_on = date('Y-m-d h:i:s');

    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);


    mysqli_query($db, "insert into `order`(user_id,address,city,pincode,payment_type,payment_status,order_status,added_on,total_price,txnid) values('$user_id','$address','$city','$pincode','$payment_type','$payment_status','$order_status','$added_on','$total_price','$txnid')");

    $order_id = mysqli_insert_id($db);

    foreach ($_SESSION['cart'] as $key => $val) {
        $productArr = get_product($db, '', '', $key);
        $price = $productArr[0]['sell_price'];
        $qty = $val['qty'];

        mysqli_query($db, "insert into `order_detail`(order_id,product_id,qty,price) values('$order_id','$key','$qty','$price')");
    }

    unset($_SESSION['cart']);

    if ($payment_type == 'payu') {
        $MERCHANT_KEY = "oZ7oo9";
        $SALT = "UkojH5TS";
        $hash_string = '';
        //$PAYU_BASE_URL = "https://secure.payu.in";
        $PAYU_BASE_URL = "https://test.payu.in";
        $action = '';
        $posted = array();
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $posted[$key] = $value;
            }
        }

        $userArr = mysqli_fetch_assoc(mysqli_query($db, "select * from users where id='$user_id'"));

        $formError = 0;
        $posted['txnid'] = $txnid;
        $posted['amount'] = $total_price;
        $posted['firstname'] = $userArr['name'];
        $posted['email'] = $userArr['email'];
        $posted['phone'] = $userArr['mobile'];
        $posted['productinfo'] = "productinfo";
        $posted['key'] = $MERCHANT_KEY;
        $hash = '';
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        if (empty($posted['hash']) && sizeof($posted) > 0) {
            if (
                empty($posted['key'])
                || empty($posted['txnid'])
                || empty($posted['amount'])
                || empty($posted['firstname'])
                || empty($posted['email'])
                || empty($posted['phone'])
                || empty($posted['productinfo'])

            ) {
                $formError = 1;
            } else {
                $hashVarsSeq = explode('|', $hashSequence);
                foreach ($hashVarsSeq as $hash_var) {
                    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                    $hash_string .= '|';
                }
                $hash_string .= $SALT;
                $hash = strtolower(hash('sha512', $hash_string));
                $action = $PAYU_BASE_URL . '/_payment';
            }
        } elseif (!empty($posted['hash'])) {
            $hash = $posted['hash'];
            $action = $PAYU_BASE_URL . '/_payment';
        }


        $formHtml = '<form method="post" name="payuForm" id="payuForm" action="' . $action . '">
<input type="hidden" name="key" value="' . $MERCHANT_KEY . '" /><input type="hidden" name="hash" value="' . $hash . '"/>
<input type="hidden" name="txnid" value="' . $posted['txnid'] . '" /><input name="amount" type="hidden" 
value="' . $posted['amount'] . '" /><input type="hidden" name="firstname" id="firstname" 
value="' . $posted['firstname'] . '" /><input type="hidden" name="email" id="email" value="' . $posted['email'] . '" />
<input type="hidden" name="phone" value="' . $posted['phone'] . '" /><textarea name="productinfo" 
style="display:none;">' . $posted['productinfo'] . '</textarea><input type="hidden" name="surl" 
value="http://localhost/fashion-ecom/payment_complete.php" /><input type="hidden" name="furl" 
value="http://localhost/fashion-ecom/payment_fail.php"/><input type="submit" style="display:none;"/></form>';
        echo $formHtml;
        echo '<script>document.getElementById("payuForm").submit();</script>';
    } else {

        ?>
        <script>
            window.location.href = './success.php';
        </script>
        <?php
    }

}





?>
<div class="container">
    <div class="row mt-5">

        <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
            <?php if (!isset($_SESSION['USER_LOGIN'])): ?>
                <div class="m-l-25 m-r--38 m-lr-0-xl ">
                    <div class="row mt-5">
                        <div class="col-lg-6">
                            <h4 class="mtext-105 cl2 txt-center p-b-30">
                                Login
                            </h4>
                            <form id="login-form">
                                <div class="form-group">

                                    <input type="text" class="form-control" type="text" name="login_email" id="login_email"
                                        placeholder="Your Email Address">
                                    <span style="color:red" class="field_error" id="login_email_error"></span>
                                </div>
                                <div class="form-group">

                                    <input type="password" name="login_password" id="login_password" class="form-control"
                                        placeholder="Your password">
                                    <span style="color:red" class="field_error" id="login_password_error"></span>
                                </div>
                                <button type="button"
                                    class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer"
                                    onclick="user_login()">
                                    Login
                                </button>
                                <div class="form-output login_msg">
                                    <p style="color:red" class="form-messege field_error"></p>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="mtext-105 cl2 txt-center p-b-30">
                                Register
                            </h4>
                            <form id="register-form" method="post">
                                <div class="form-group">

                                    <input class="form-control" type="text" id="name" name="name" placeholder="Your Name">
                                    <span style="color:red" class="field_error" id="name_error"></span>
                                </div>
                                <div class="form-group">

                                    <input class="form-control" type="text" id="email" name="email"
                                        placeholder="Your Email">
                                    <span style="color:red" class="field_error" id="email_error"></span>
                                </div>
                                <div class="form-group">

                                    <input class="form-control" type="text" id="mobile" name="mobile"
                                        placeholder="Your Mobile">
                                    <span style="color:red" class="field_error" id="mobile_error"></span>
                                </div>
                                <div class="form-group">

                                    <input class="form-control" type="password" id="password" name="password"
                                        placeholder="Your password">
                                    <span style="color:red" class="field_error" id="password_error"></span>
                                </div>
                                <button type="button"
                                    class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer"
                                    onclick="user_register()">
                                    Register
                                </button>
                                <div class="form-output login_msg">
                                    <p style="color:green" class="form-messege register_msg"></p>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            <?php else: ?>
                <!-- accordion -->
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                    aria-expanded="false" aria-controls="collapseTwo">
                                    Payment Information
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <form method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="address" placeholder="Address" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="city" placeholder="City" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="pincode" id="pincode" placeholder="zip code" oninput="checkPincode()">
                                   
                                    </div>
                                    <span class="field_error" id="pincode_error"></span>
                                    <div id="availabilityResult" class="mt-3"></div>
                                    <div class="form-group">
                                        COD <input type="radio" name="payment_type" value="COD" required />
                                      PayU <input type="radio" name="payment_type" value="payu" required />
                                    </div>
                                    <input type="submit" name="submit" class="btn btn-primary" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- end -->
        <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50 mt-5">
            <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                <h4 class="mtext-109 cl2 p-b-30">
                    Cart Totals
                </h4>
                <?php
                $cart_total = 0;
                foreach ($_SESSION['cart'] as $key => $val) {
                    $productArr = get_product($db, '', '', $key);
                    $pname = $productArr[0]['name'];
                    $price = $productArr[0]['sell_price'];
                    $front_image1 = explode('/', $productArr[0]['image1'])[4];
                    $qty = $val['qty'];
                    $cart_total = $cart_total + ($price * $qty);
                    ?>

     

                    <div class="flex-w flex-t bor12 p-t-15 p-b-30">


                        <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">

                            <div class="">


                                <div class="single-item">
                                    <div class="how-itemcart1">
                                        <img src="./admin/uploaded-files/product/<?php echo $front_image1 ?>" alt="IMG">
                                    </div>
                                    <div class="single-item__content ">
                                        <a href="#" class="mr-3"><?php echo $pname ?></a>
                                        <span class="price"><?php echo $price * $qty ?></span>
                                        <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key ?>','remove')"><i
                                        class="fa fa-trash "></i></a>
                                    </div>
                                    <div class="single-item__remove">
                                    
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="flex-w flex-t p-t-27 p-b-33">
                    <div class="size-208">
                        <span class="mtext-101 cl2">
                            Total:
                        </span>
                    </div>

                    <div class="size-209 p-t-1">
                        <span class="mtext-110 cl2">
                            <?php echo $cart_total ?>
                        </span>
                    </div>
                </div>

                <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                    Proceed to Checkout
                </button>
            </div>
        </div>
    </div>
</div>


<?php include './footer.php'; ?>