<?php
require './admin/libs/database.php';
require './helpers/helpers.php';
//$db = Database::getInstance();


$name = get_safe_value($db, $_POST['name']);
$email = get_safe_value($db, $_POST['email']);
$mobile = get_safe_value($db, $_POST['mobile']);
$password = get_safe_value($db, $_POST['password']);

$check_user = mysqli_num_rows(mysqli_query($db, "select * from users where email='$email'"));
//print_r($check_user);die;
if ($check_user > 0) {
    echo "email_present";
} else {

    //mysqli_query($db,"insert into users(name,email,mobile,password) values('$name','$email','$mobile','$password')");
    //echo "insert";
    $sql = "INSERT INTO users(name,email,mobile,password)
   values('$name','$email','$mobile','$password')";
   //echo $sql;die;
    if ($db->query($sql) === true) {
        echo "insert";
    } else {
        echo "error";
    }
}
