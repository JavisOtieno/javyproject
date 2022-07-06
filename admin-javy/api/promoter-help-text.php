<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php
if(isset($_GET['id'])){
    $promoter_id=$_GET['id'];
}else{
  $promoter_id=56;
}

$query='SELECT * FROM users WHERE user_id='.$dealer_id;

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);



$help_text = "1. How does this work?
Sign up, get a free website with listed products, market and when a customer orders, we deliver to the client and you get paid.

2. How do you make payments?
Mpesa or cash. Since cash is only available for those within the CBD, we mostly use Mpesa

3. When do you make payments?
After a sale is complete, funds will become available in your account usually within the same day. Whether you choose to access them immediately or not, will be upto you.

4. How will my clients get the products?
We’ll deliver to your clients.

5. How do I make sales from my website?
The more you share your website link as well as promotional images under the promote page plus finding your own unique ways of marketing, the higher your chances of selling.

6. What are the commission rates?
Check under products. Each product has a price as well as their commission values listed.

7. What is the delivery fee?
Delivery charges vary from 200 to 1500. Free delivery within Nairobi CDB.

7. How do I upload my own products on the site?
Since you opened up a promoter account, you're currently not able to upload any products. To get a website with your own products. Opening up a supplier account will let you add your own products

Any more questions? Contact us on 0716 545459 or email us on info@javy.co.ke";

$response["help"]=$help_text;
 //array_push($response["help"], $help_text);


echo json_encode($response);