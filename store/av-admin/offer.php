<?php include 'php_action/db_connect.php';


$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$host=$_SERVER['HTTP_HOST'];
session_start();
if (isset($_SESSION['userId'])) {

	$userId=$_SESSION['userId'];
    

    $sqlusers ="SELECT * FROM users WHERE user_id = $userId";
 $userResult=$connect->query($sqlusers);
$storeResult=$userResult->fetch_assoc();
$storename=$storeResult['storename'];
$email=$storeResult['email'];
$co_ke=$storeResult['.co.ke'];
$validation_status=$storeResult['validation_status'];

if($co_ke){
  $website_ke='.co.ke';
}else{
  $website_ke='.av.ke';
}

}elseif(isset($_GET['image_on_store'])){

	$storename=$_GET['image_on_store'];

}

    $id=$_GET['id'];

    $sql="SELECT * FROM offers2 WHERE id=".$id;

    $result=$connect->query($sql);

    if ($row=$result->fetch_assoc()){
  $offer_id=$row['id'];
  $title=$row['title'];
  $font_size=$row['font_size'];
  $original_image=$row['original_image'];
   $fill_color=$row['fill_color'];
    $x=$row['x'];
    $y=$row['y'];
    $original_image=$row['original_image'];
    $position=$row['position'];

    //handling the offers submitted before on sql which automatically made position values zero
    if($position==0){
      $position=1;
    }

    }

  showImage($font_size,$fill_color,$x,$y,$position,$original_image,$storename,$website_ke);

    function showImage($fontsize, $fillcolor,$x,$y,$position,$original_image,$storename,$website_ke){

$Imagick = new Imagick();
/* Create a drawing object and set the font size */
$ImagickDraw = new ImagickDraw();
$ImagickDraw->setFontSize( $fontsize );
$ImagickDraw->setFillColor($fillcolor);
$ImagickDraw->setStrokeWidth(0.5);
$ImagickDraw->setFontWeight(400);
/* Read image into object*/
$Imagick->readImage( $original_image );

/* Seek the place for the text */
$ImagickDraw->setGravity( $position );
/* Write the text on the image */
$Imagick->annotateImage( $ImagickDraw, $x, $y, 0, "www.".$storename.$website_ke );
/* Set format to png */
$Imagick->setImageFormat( 'jpg' );
/* Output */

$offer_image="offer".$id;

file_put_contents ($offer_image.".jpg", $Imagick);



//echo "<img src='".$offer_image.".jpg'/>";
//echo "fsdf";

header( "Content-Type: image/{$Imagick->getImageFormat()}" );
if(isset($_GET['download'])){
  header("Location: download.php?img=".$offer_image.".jpg");
}


echo $Imagick->getImageBlob();

echo '<img src="download.php?img='.$offer_image.'.jpg" alt="test">';






  
}

?>