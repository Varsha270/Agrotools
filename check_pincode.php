<?php 

require './admin/libs/database.php';


// Fetch the pincode from the request
$pincode = $_POST['pincode'];
//print_r($pincode);die;

// Directly executing SQL query
$sql = "SELECT pincode FROM available_pincodes WHERE pincode = '$pincode'";

// Optionally, you can debug the query by uncommenting the next line
// echo $sql; die;

$res = $db->query($sql);

// Check if the query returned any rows
if ($res->num_rows > 0) {
    // Pincode is available
    echo json_encode(['status' => 'available']);
} else {
    // Pincode is not available
    echo json_encode(['status' => 'unavailable']);
}












?>