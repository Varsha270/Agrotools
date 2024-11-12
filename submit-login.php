<?php
require './admin/libs/database.php';
require './helpers/helpers.php';
//$db = Database::getInstance();

$email = get_safe_value($db, $_POST['email']);
$password = get_safe_value($db, $_POST['password']);
$res = mysqli_query($db, "select * from users where email='$email' and password='$password'");
$check_user = mysqli_num_rows($res);
if ($check_user > 0) {
    $row = mysqli_fetch_assoc($res);
    session_start();
    $_SESSION['USER_LOGIN'] = 'yes';
    $_SESSION['USER_ID'] = $row['id'];
    $_SESSION['USER_NAME'] = $row['name'];
    $_SESSION['USER_EMAIL'] = $row['email'];
    $_SESSION['USER_PHONE'] = $row['mobile'];
    echo "valid";
} else {
    echo "wrong";
}
?>