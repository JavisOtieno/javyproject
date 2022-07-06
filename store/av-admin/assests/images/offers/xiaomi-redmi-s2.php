<?php




$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$host=$_SERVER['HTTP_HOST'];
session_start();
if (isset($_SESSION['userId'])) {

	$userId=$_SESSION['userId'];
    
    include '../../../php_action/db_connect.php'; 

    $sqlusers ="SELECT storename,email,validation_status FROM users WHERE user_id = $userId";
 $userResult=$connect->query($sqlusers);
$storeResult=$userResult->fetch_assoc();
$storename=$storeResult['storename'];
$email=$storeResult['email'];
$validation_status=$storeResult['validation_status'];

}elseif(isset($_GET['image_on_store'])){

	$storename=$_GET['image_on_store'];

}
 



/* Create Imagick object */
$Imagick = new Imagick();

/* Create a drawing object and set the font size */
$ImagickDraw = new ImagickDraw();
$ImagickDraw->setFontSize( 60 );
$ImagickDraw->setFillColor('#FFFFFF');
$ImagickDraw->setStrokeWidth(0.5);

$ImagickDraw->setFontWeight(600);
/* Read image into object*/
$Imagick->readImage( 'xiaomi-redmi-s2.jpg' );

/* Seek the place for the text */
$ImagickDraw->setGravity( Imagick::GRAVITY_NORTHWEST );

/* Write the text on the image */

$Imagick->annotateImage( $ImagickDraw, 77 , 595.34 , 0, "www.".$storename.".av.ke" );

/* Set format to png */
$Imagick->setImageFormat( 'jpg' );

/* Output */
header( "Content-Type: image/{$Imagick->getImageFormat()}" );
echo $Imagick->getImageBlob();

?>