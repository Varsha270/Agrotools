<?php

//require_once ("./src/Database.php");
//require_once ("./src/Session.php");
require './admin/libs/database.php';
session_start();
if (!isset($_GET['product_id'])) {
  header('location:index.php');
  exit();
} else {
  $product_id = $_GET['product_id'];
}

//print_r($product_id);die;

include ("./src/config.php");

$html = '';

if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) {
  $hash = hash('sha512', $key . '|' . $_POST['txnid'] . '|' . $_POST['amount'] . '|' . $_POST['productinfo'] . '|' . $_POST['firstname'] . '|' . $_POST['email'] . '|' . $_POST['udf1'] . '|' . $_POST['udf2'] . '|' . $_POST['udf3'] . '|' . $_POST['udf4'] . '|' . $_POST['udf5'] . '||||||' . $salt);


  $_SESSION['salt'] = $salt; //save salt in session to use during Hash validation in response
  //sha512(key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5||||||SALT)


  $html = '<form action="' . $action . '" id="payment_form_submit" method="post">
      <input type="hidden" id="udf5" name="udf5" value="' . $_POST['udf5'] . '" />
       <input type="hidden" id="udf1" name="udf1" value="' . $_POST['udf1'] . '" />
       <input type="hidden" id="udf2" name="udf2" value="' . $_POST['udf2'] . '" />
       <input type="hidden" id="udf3" name="udf3" value="' . $_POST['udf3'] . '" />
       <input type="hidden" id="udf4" name="udf4" value="' . $_POST['udf4'] . '" />

      <input type="hidden" id="surl" name="surl" value="' . $success_url . '" />
      <input type="hidden" id="furl" name="furl" value="' . $failed_url . '" />
      <input type="hidden" id="curl" name="curl" value="' . $cancelled_url . '" />
      <input type="hidden" id="key" name="key" value="' . $key . '" />
      <input type="hidden" id="txnid" name="txnid" value="' . $_POST['txnid'] . '" />
      <input type="hidden" id="amount" name="amount" value="' . $_POST['amount'] . '" />
      <input type="hidden" id="start_date" name="start_date" value="' . $_POST['start_date'] . '" />
      <input type="hidden" id="end_date" name="end_date" value="' . $_POST['end_date'] . '" />
      <input type="hidden" id="customer_id" name="userid" value="' . $_POST['userid'] . '" />

      <input type="hidden" id="productinfo" name="productinfo" value="' . $_POST['productinfo'] . '" />
      <input type="hidden" id="firstname" name="firstname" value="' . $_POST['firstname'] . '" />
      <input type="hidden" id="Lastname" name="Lastname" value="' . $_POST['Lastname'] . '" />
      <input type="hidden" id="Zipcode" name="Zipcode" value="' . $_POST['Zipcode'] . '" />
      <input type="hidden" id="email" name="email" value="' . $_POST['email'] . '" />
      <input type="hidden" id="phone" name="phone" value="' . $_POST['phone'] . '" />
      <input type="hidden" id="address1" name="address1" value="' . $_POST['address1'] . '" />
      <input type="hidden" id="address2" name="address2" value="' . (isset($_POST['address2']) ? $_POST['address2'] : '') . '" />
      <input type="hidden" id="city" name="city" value="' . $_POST['city'] . '" />
      <input type="hidden" id="state" name="state" value="' . $_POST['state'] . '" />
      <input type="hidden" id="country" name="country" value="' . $_POST['country'] . '" />
      <input type="hidden" id="Pg" name="Pg" value="' . $_POST['Pg'] . '" />
      <input type="hidden" id="hash" name="hash" value="' . $hash . '" />
      </form>
      <script type="text/javascript"><!--
        document.getElementById("payment_form_submit").submit();  
      //-->
      </script>';
}
function getCallbackUrl()
{
  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $uri = str_replace('/index.php', '/', $_SERVER['REQUEST_URI']);
  return $protocol . $_SERVER['HTTP_HOST'] . $uri . 'response.php';
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Payment - Synchlab Coding </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


  <div class="container">
    <div class="row">
      <div class="col-sm-12 form-container">
        <h1>Payment</h1>
        <hr>

        <?php
        //include './header.php';
        //session_start();
        require_once './src/Session.php';

        if (!isset($_SESSION['USER_ID']) || !$_SESSION['USER_LOGIN'] === 'yes') {
          // Set a session variable with the message
          $_SESSION['login_message'] = 'You are not logged in. Please log in to lend tool';
          // Redirect to login.php
          header("Location: ./login.php");
          exit();
        }

        //$user = Session::get('user');
        
        //print_r($_POST['start_date']);die;



        $lending_id = uniqid();
        /*$firstname=$_SESSION['fname']; 
        $lastname=$_SESSION['lname'];
        $email=$_SESSION['email'];
        $mobile=$_SESSION['mobile'];
        $address=$_SESSION['address'];
        $note=$_SESSION['note'];
        $carid =  $_SESSION['carid'];
        $start_date = $_SESSION['start_date'];

        $end_date = $_SESSION['end_date'];
        $customer_id = $user->id;
        $price =  $_SESSION['amount'];*/

        /*$firstname = $user->name;
        $lastname = $user->name;
        $email = $user->email;
        $mobile = $user->phone;
        $address = $user->address;*/

        $user_id =  $_SESSION['USER_ID'];
        $firstname = $_SESSION['USER_NAME'];
        $lastname = $_SESSION['USER_NAME'];
        $email = $_SESSION['USER_EMAIL'];
        $mobile = $_SESSION['USER_PHONE'];
        $address = 'Demo address';

        

        $note = 'demo note';
        $product_id = $_GET['product_id'];
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        //$customer_id = $user->id;
        $amount = $_GET['total_amount'];
       

        $sql = "SELECT * FROM product WHERE id = '$product_id'";

        $res = $db->query($sql);
        $product_details = $res->fetch_object();
        $product_name = $product_details->name;
        //print_r( $product_id );die;
        /*$sql = "SELECT * FROM customers WHERE id = '$user->id'";

        $res = $db->query($sql);
        $customer = $res->fetch_object();*/


        $webtitle = 'Synchlab Coding '; // Change web title
        $displayCurrency = 'INR';
        $imageurl = 'https://synchlabcoding.com';

        ?>
        <div class="row">


          
            <!--<div class="col-lg-4 mx-auto">

              <div class="card ">

                <div class="card-body text-center">

                  <h5>Your profile is not verified</h5>
                  <h3>Upload documents to verify your profile</h3>
                  <a href="./profile.php" class="btn btn-primary btn-sm">verify profile</a>
                </div>

              </div>
            </div>-->
         

            <div class="col-8">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Payer Information</h5>
                  <div class="row">
                    <div class="col-md-6">
                      <p><strong>First Name:</strong> <?php echo $firstname; ?></p>
                      <p><strong>Last Name:</strong> <?php echo $lastname; ?></p>
                      <p><strong>Email:</strong> <?php echo $email; ?></p>
                      <p><strong>Mobile:</strong> <?php echo $mobile; ?></p>
                    </div>
                    <div class="col-md-6">
                      <p><strong>Address:</strong> <?php echo $address; ?></p>
                      <p><strong>Start Trip Time:</strong> <?php echo $start_date; ?></p>
                      <p><strong>End Trip Time:</strong> <?php echo $end_date; ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4 text-center">
              <?php
              $sql = "SELECT * FROM product WHERE id = '$product_id'";
              //echo $sql;die;
              $res = $db->query($sql);
              $product_details = $res->fetch_object();
              //print_r($product_details);die;
              $fileName1 = explode('/', $product_details->image1)[4];
              echo '<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="./admin/uploaded-files/product/' . $fileName1 . '" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">' . $product_details->name . ' </h5>
    <p class="card-text">' . $amount . ' INR</p>
  </div>
</div>';


              ?>
              <br>

              <form action="" id="payment_form" method="post">
                <input type="hidden" id="udf5" name="udf5" value="PayUBiz_PHP7_Kit" />
                <input type="hidden" id="udf1" name="udf1" value="<?php echo $product_id; ?>" />
                <input type="hidden" id="udf2" name="udf2" value="<?php echo $start_date; ?>" />
                <input type="hidden" id="udf3" name="udf3" value="<?php echo $end_date; ?>" />
                <input type="hidden" id="udf4" name="udf4" value="<?php echo $user_id; ?>" />

                <div class="dv">

                  <span>
                    <input type="hidden" id="txnid" name="txnid" placeholder="Transaction ID"
                      value="<?php echo "Txn" . rand(10000, 99999999) ?>" /></span>
                </div>

                <div class="dv">

                  <span>
                    <input type="hidden" id="amount" name="amount" placeholder="Amount"
                      value="<?php echo $amount; ?>" /></span>
                </div>
                <div class="dv">

                  <span>
                    <input type="hidden" id="start_date" name="start_date" placeholder="start date"
                      value="<?php echo $start_date; ?>" /></span>
                </div>
                <div class="dv">

                  <span>
                    <input type="hidden" id="end_date" name="end_date" placeholder="end date"
                      value="<?php echo $end_date; ?>" /></span>
                </div>
                <div class="dv">

                  <span>
                    <input type="hidden" id="userid" name="userid" placeholder="customer_id"
                      value="<?php echo $user_id; ?>" /></span>
                </div>
                <div class="dv">

                  <span>
                    <input type="hidden" id="productinfo" name="productinfo" placeholder="Product Info"
                      value="<?php echo $product_name; ?>" /></span>
                </div>
                <div class="dv">
                  <span>
                    <input type="hidden" id="firstname" name="firstname" placeholder="First Name"
                      value="<?php echo $firstname; ?>" /></span>
                </div>

                <div class="dv">

                  <span>
                    <input type="hidden" id="Lastname" name="Lastname" placeholder="Last Name"
                      value="<?php echo $lastname; ?>" /></span>
                </div>
                <div class="dv">

                  <span>
                    <input type="hidden" id="Zipcode" name="Zipcode" placeholder="Zip Code" value="" /></span>
                </div>
                <div class="dv">

                  <span>
                    <input type="hidden" id="email" name="email" placeholder="Email ID"
                      value="<?php echo $email; ?>" /></span>
                </div>

                <div class="dv">

                  <span>
                    <input type="hidden" id="phone" name="phone" placeholder="Mobile/Cell Number"
                      value="<?php echo $mobile; ?>" /></span>
                </div>

                <div class="dv">

                  <span>
                    <input type="hidden" id="address1" name="address1" placeholder="Address1"
                      value="<?php echo $address; ?>" /></span>
                </div>

                <div class="dv">

                  <span>
                    <input type="hidden" id="address2" name="address2" placeholder="Address2" value="" /></span>
                </div>

                <div class="dv">

                  <span>
                    <input type="hidden" id="city" name="city" placeholder="City" value="" /></span>
                </div>

                <div class="dv">

                  <span><input type="hidden" id="state" name="state" placeholder="State" value="" /></span>
                </div>

                <div class="dv">

                  <span><input type="hidden" id="country" name="country" placeholder="Country" value="" /></span>
                </div>

                <div class="dv">

                  <span>
                    <!-- Not mandatory but fixed code can be passed to Payment Gateway to show default payment 
        option tab. e.g. NB, CC, DC, CASH, EMI. Refer PDF for more details. //-->
                    <input type="hidden" id="Pg" name="Pg" placeholder="PG" value="" /></span>
                </div>

                <div><input class="btn btn-primary" type="button" id="btnsubmit" name="btnsubmit" value="Pay Now"
                    onclick="frmsubmit(); return true;" /></div>
              </form>
              <?php if ($html)
                echo $html; //submit request to PayUBiz  ?>

            </div>
            <script type="text/javascript">

              function frmsubmit() {
                document.getElementById("payment_form").submit();
                return true;
              }

            </script>

          </div>
        </div>
   
    </div>

  </div>
</body>

</html>