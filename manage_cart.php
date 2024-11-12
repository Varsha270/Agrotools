<?php
require('./admin/libs/database.php');
require('./helpers/helpers.php');
require('add_to_cart.php');

$pid=get_safe_value($db,$_POST['pid']);
$qty=get_safe_value($db,$_POST['qty']);
$type=get_safe_value($db,$_POST['type']);

//print_r($type);

$obj=new add_to_cart();

if($type=='add'){
	$obj->addProduct($pid,$qty);
}

if($type=='remove'){
	$obj->removeProduct($pid);
}

if($type=='update'){
	$obj->updateProduct($pid,$qty);
}

echo $obj->totalProduct();
?>