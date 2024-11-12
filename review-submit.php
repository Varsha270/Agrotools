<?php

require './admin/libs/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $product_id = $db->real_escape_string($product_id);
    $name = $db->real_escape_string($name);
    $email = $db->real_escape_string($email);
    $rating = (int) $rating; // Cast to integer for safety
    $review = $db->real_escape_string($review);

   
    if (!empty($name) && !empty($email) && !empty($rating) && !empty($review)) {
  
        $sql = "INSERT INTO reviews (product_id, name, email, rating, review) 
                VALUES ('$product_id', '$name', '$email', $rating, '$review')";

        // Check if the query was successful
        if ($db->query($sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Review submitted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error submitting review']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Please fill all the fields']);
    }
}

?>
