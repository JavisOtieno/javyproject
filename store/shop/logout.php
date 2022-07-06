<?php 

require('connect.inc.php');
require('subdomain_storename.php');

session_start();

// remove all session variables
session_unset(); 

setcookie('phone_email',$password,time() - 1);
setcookie('password',$password,time() - 1);
// destroy the session 
session_destroy(); 

//header('location: http://localhost/websites/stock-2/login.php');
header('location: login.php');

?>