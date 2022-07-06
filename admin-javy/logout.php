<?php 

require_once 'core.php';

// remove all session variables
session_unset(); 

setcookie('storename',$storename,time() - 1);
setcookie('password',$password,time() - 1);
// destroy the session 
session_destroy(); 

//header('location: http://localhost/websites/stock-2/login.php');
header('location: login.php');

?>