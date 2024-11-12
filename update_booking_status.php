<?php
session_start();
require './admin/libs/database.php';
require './helpers/helpers.php';

// Check if the user is logged in
if (!isset($_SESSION['USER_ID'])) {
    echo "User is not logged in or session is missing.";
    exit;
}

// Get the lending_id from the POST request
$lending_id = get_safe_value($db, $_POST['lending_id']);

// Update the booking status to 'Completed'
$sql = "UPDATE lendings SET booking_status = 'Completed' WHERE lending_id = '$lending_id' AND user_id = '".$_SESSION['USER_ID']."'";

if ($db->query($sql)) {
    // Redirect back to the bookings page after updating
    header("Location: view_my_booking.php");
    exit;
} else {
    echo "Error updating booking status: " . mysqli_error($db);
}
?>
