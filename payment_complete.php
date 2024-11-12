<?php
session_start();
require './admin/libs/database.php';
require './helpers/helpers.php';

// Check if the user is logged in
if (!isset($_SESSION['USER_ID'])) {
    echo "User is not logged in or session is missing.";
    exit;
}

$user_id = $_SESSION['USER_ID']; // Retrieve user ID from the session

// Get the parameters from the GET request
$product_id = get_safe_value($db, $_GET['product_id']);
$start_date = get_safe_value($db, $_GET['start_date']);
$end_date = get_safe_value($db, $_GET['end_date']);
$total_amount = get_safe_value($db, $_GET['total_amount']);

// Ensure required parameters are available
if ($product_id && $start_date && $end_date && $total_amount) {
    // Generate a random txn_id (for example purposes)
    $txn_id = 'TXN' . rand(1000, 9999);
    // Dummy values for the remaining fields
    $payment_id = 'PAY' . rand(1000, 9999);
    $payment_mode = 'Online'; // Dummy payment mode
    $payment_status = 'Success'; // Assuming payment is successful
    $payment_date = date('Y-m-d H:i:s'); // Current date and time
    $booking_date = date('Y-m-d H:i:s'); // Current date and time

    // Insert into the `lendings` table, excluding the `lending_id` (auto-incremented)
    $insert_lending_sql = "INSERT INTO lendings 
                            (user_id, product_id, start_date, end_date, amount, booking_status, txnid, payment_id, payment_mode, payment_status, payment_date, booking_date)
                           VALUES 
                            ('$user_id', '$product_id', '$start_date', '$end_date', '$total_amount', 'Pending', '$txn_id', '$payment_id', '$payment_mode', '$payment_status', '$payment_date', '$booking_date')";

    if (mysqli_query($db, $insert_lending_sql)) {
        // Redirect to the success page if everything goes fine
        header("Location: success.php");
        exit;
    } else {
        echo "Error inserting into lendings table: " . mysqli_error($db);
    }
} else {
    echo "Required parameters are missing.";
}
?>
