<?php

require './admin/libs/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pincode = $db->real_escape_string($_POST['pincode']);


    $sql = "SELECT pincode FROM available_pincodes WHERE pincode = '$pincode'";
    //echo $sql;die;
    $res = $db->query($sql);

    echo '<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .message-container {
        max-width: 400px;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .message {
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    .success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }
    .error {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }
    .btn {
        padding: 12px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
        color: white;
        display: inline-block;
        margin-top: 10px;
    }
    .btn-success {
        background-color: #28a745;
    }
    .btn-error {
        background-color: #dc3545;
    }
    .btn:hover {
        opacity: 0.9;
    }
</style>';

    echo '<div class="message-container">';


    if ($res->num_rows > 0) {

        echo '<div class="message success">
            <h3>Service is available in your area!</h3>
          </div>
          <a href="./index.php" class="btn btn-success">Start Shopping</a>';
    } else {

        echo '<div class="message error">
            <h3>Sorry, our service is not available in your area.</h3>
          </div>
          <a href="contact.php" class="btn btn-error">Contact Us</a>';
    }

    echo '</div>';

}


?>