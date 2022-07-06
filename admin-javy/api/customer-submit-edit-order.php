<?php   

$base = dirname(dirname(__FILE__)); // now $base contains "app"

require('../connect.inc.php');
//require('/../../store/admin/subdomain_storename.php');
require('../email-sendgrid/sendgrid-php.php'); 

//getting the dealer id
//localhost code
//$subdomain="javis";
//$storename="javis";


if(isset($_GET['name'])&&isset($_GET['email'])&&isset($_GET['phone_number'])
  &&!empty($_GET['email'])&&!empty($_GET['name'])&&!empty($_GET['phone_number'])){

$name=mysqli_real_escape_string($db_link,$_GET['name']);
$email=mysqli_real_escape_string($db_link,$_GET['email']);
$order_id=mysqli_real_escape_string($db_link,$_GET['order_id']);
//$product_id=$_GET['product_id'];
$delivery_details=mysqli_real_escape_string($db_link,$_GET['delivery_details']);
$phone_number=mysqli_real_escape_string($db_link,$_GET['phone_number']);


//$orderdate=time();

  $sql = "UPDATE deals SET name='$name',email='$email',phone='$phone_number',delivery_details='$delivery_details' WHERE id='$order_id'";


  if(($connect->query($sql) === true)) {


    $valid['success'] = true;
    $valid['messages'] = "Order succesfully edited. Order number : ".$order_id
    ." Date : ".date('d/m/Y \a\t h:iA' , $orderdate)." Total : ".number_format($product_price); 
  }else  {
    $valid['success'] = false;
    $valid['messages'] = 'Edit Failed. Please try again.';
  
}
  
  $connect->close();

}
// /if $_POST


else{
  $valid['success'] = false;
  $valid['messages'] = 'Enter Details';
} 



echo json_encode($valid);