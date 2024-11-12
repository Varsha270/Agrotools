<?php
require './admin/libs/database.php';
include ("./src/config.php");
$postdata = $_POST;
//print_r($postdata);die;
$msg = '';
$status = '';
if (isset($postdata['key'])) {
    //print_r($postdata);die;
    $key = $postdata['key'];
    $txnid = $postdata['txnid'];
    $amount = $postdata['amount'];
    $productInfo = $postdata['productinfo'];
    $firstname = $postdata['firstname'];
    $lastname = $postdata['lastname'];
    $phone = $postdata['phone'];
    $email = $postdata['email'];
    $address1 = $postdata['address1'];
    $udf5 = $postdata['udf5'];
    $product_id = $postdata['udf1'];
    $start_date = $postdata['udf2'];
    $end_date = $postdata['udf3'];
    $user_id = $postdata['udf4'];
    $status = $postdata['status'];
    $resphash = $postdata['hash'];
    //Calculate response hash to verify 
    $keyString = $key . '|' . $txnid . '|' . $amount . '|' . $productInfo . '|' . $firstname . '|' . $email . '|' . $postdata['udf1'] . '|' . $postdata['udf2'] . '|' . $postdata['udf3'] . '|' . $postdata['udf4'] . '|' . $udf5 . '|||||';
    $keyArray = explode("|", $keyString);
    $reverseKeyArray = array_reverse($keyArray);
    $reverseKeyString = implode("|", $reverseKeyArray);
    $CalcHashString = strtolower(hash('sha512', $salt . '|' . $status . '|' . $reverseKeyString)); //hash without additionalcharges

    //check for presence of additionalcharges parameter in response.
    $additionalCharges = "";

    if (isset($postdata["additionalCharges"])) {
        $additionalCharges = $postdata["additionalCharges"];
        //hash with additionalcharges
        $CalcHashString = strtolower(hash('sha512', $additionalCharges . '|' . $salt . '|' . $status . '|' . $reverseKeyString));
    }
    //Comapre status and hash. Hash verification is mandatory.
    if ($status == 'success' && $resphash == $CalcHashString) {
        $msg = "Transaction Successful, Hash Verified...<br />";
        //Do success order processing here...
    } else {
        //tampered or failed
        $msg = "Payment failed for Hash not verified...";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Status - Synchlab Coding </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 form-container">
                <h1>Payment Status</h1>
                <hr>


                <div class="row">
                    <div class="col-8">
                        <?php

                        if ($status == 'success' && $resphash == $CalcHashString && $txnid != '') {
                            $subject = 'Tool Lending has been successful..';
                            $currency = 'INR';
                            $date = new DateTime(null, new DateTimezone("Asia/Kolkata"));
                            $payment_date = $date->format('Y-m-d H:i:s');
                         
                            $countts = null; // Define $countts in a wider scope
                        
                            $sql = "SELECT count(*) FROM lendings WHERE txnid='$txnid'";
                            //echo $sql;die;
                            if ($result = $db->query($sql)) {
                                $row = $result->fetch_row();
                                $countts = $row[0];
                               
                            }
                           
                            if ($txnid != '') {

                                if ($countts <= 0) {


                                    $lending_id = 'BK' . uniqid();

            
                                    $sql = "INSERT INTO lendings(lending_id, user_id, product_id, start_date, end_date, amount, booking_status, txnid, payment_mode, payment_status, payment_date) 
        VALUES ('$lending_id','$user_id','$product_id','$start_date', '$end_date', '$amount', 'Booked', '$txnid', 'online', '$status', '$payment_date')";
                                  
                                  //echo $sql;die;

                                    //mysqli_query($db, $sql);
                                    if (mysqli_query($db, $sql)) {
                                       
                                        $update_sql = "UPDATE product SET is_lend = '1' WHERE id = '$product_id'";
                            
                                       
                                        mysqli_query($db, $update_sql);
                                    } else {
                                        echo "Error: " . mysqli_error($db);
                                    }
                                }



                                echo '<h2 style="color:#33FF00;">' . $subject . '</h2><hr>';

                                $sql = "SELECT * FROM lendings WHERE txnid='$txnid'";
                                $result = mysqli_query($db, $sql);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $dbdate = $row['payment_date'];
                                    $booking_status =  $row['booking_status'];
                                    $lending_id =  $row['lending_id'];
                                }

                                echo '<table class="table">';
                                echo '<tr>';
                                echo '<th>Booking ID:</th>';
                                echo '<td>' . $lending_id . '</td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<th>Paid Amount:</th>';
                                echo '<td>' . $amount . ' ' . $currency . '</td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<th>Booking Status:</th>';
                                echo '<td style="color:green;">' . $booking_status . ' </td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<th>Payment Status:</th>';
                                echo '<td>' . $status . '</td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<th>Payer Email:</th>';
                                echo '<td>' . $email . '</td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<th>Name:</th>';
                                echo '<td>' . $firstname . ' ' . $lastname . '</td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<th>Mobile No:</th>';
                                echo '<td>' . $phone . '</td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<th>Date :</th>';
                                echo '<td>' . $dbdate . '</td>';
                                echo '</tr>';
                                echo '</table>';
                            }
                        } else {
                            $html = "<p><div class='errmsg'>Invalid Transaction. Please Try Again</div></p>";
                            $error_found = 1;
                        }

                        if (isset($html)) {
                            echo $html;
                        }
                        ?>
                    </div>
                    <div class="col-4 text-center">
                        <?php
                        if (!isset($error_found)) {
                            $sql = "SELECT * FROM product WHERE id = '$product_id'";
                           // echo $sql;
                            $res = $db->query($sql);
                            $product_details = $res->fetch_object();
                            $fileName1 = explode('/', $product_details->image1)[4];

                            echo '<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="./admin/uploaded-files/product/' . $fileName1 . '" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">' . $product_details->name . '</h5>
  </div>
</div>';
                        }
                        ?>
                        <br>
                        <a href="./my-bookings.php" class="btn btn-primary">Go to My Bookings</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</body>

</html>