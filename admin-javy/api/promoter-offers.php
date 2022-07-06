<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php
if(isset($_GET['id'])){
    $promoter_id=$_GET['id'];
}

$query2='SELECT * FROM users WHERE user_id='.$promoter_id;
$query_run2=mysqli_query($db_link,$query2);
while( $row2=mysqli_fetch_array($query_run2) ){
$storename=$row2['storename'];
}



$query='SELECT * FROM offers2 WHERE status=1 ORDER BY id DESC LIMIT 25';

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["offers"] = array();

while( $row=mysqli_fetch_array($query_run) ){
  $offer = array();
  $offer["offer_id"] = $row["id"];
  $offer["offer_title"] = $row["title"];
  $font_size=$row['font_size'];


  $image_url=$row['image'];

$offer['offer_image']='http://promote.javy.co.ke/'.$image_url. '?image_on_store='.$storename;

    if($image_url=='' && $font_size>0){
	$image_url='offer.php?id='.$offer["offer_id"];
$offer['offer_image']='http://promote.javy.co.ke/'.$image_url.'&image_on_store='.$storename;

  }
  else if($image_url==''){
    $image_url=$row['original_image'];

$offer['offer_image']='http://promote.javy.co.ke/'.$image_url;

  }

 array_push($response["offers"], $offer);

  }


echo json_encode($response);