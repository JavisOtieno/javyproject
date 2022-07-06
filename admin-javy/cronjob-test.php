<?php
include 'core.php';
require 'connect.inc.php';

$sql="UPDATE `last_saved_contact` SET cronjob='it works'";

if($connect->query($sql)){
    $valid['success'] = true;
    $valid['messages'] = "Product Price Succesfully Edited";        
}





?>