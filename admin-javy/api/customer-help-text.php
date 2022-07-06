<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php
if(isset($_GET['id'])){
    $customer_id=$_GET['id'];
}else{
  $customer_id=1872;
}

$query='SELECT * FROM customers WHERE id='.$customer_id;

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);


$help_text = "1. Are all products on Javis original and genuine?
Yes. We are committed to offering our customers only 100% genuine and original products. We also take all necessary actions to ensure this. Suppliers whose products are found to be faulty have their product listings terminated.

    2. How do I pay?
You can choose from the different payment methods available. Please find below the list of available payment methods:

Cash On Delivery (easy and simple at your doorstep)
Mobile Money (for instance Mpesa, Airtel Money)

3. How do I place an order on Javis?
Shopping on Javis is easy! Once you have found the product you want to buy, just follow the steps below:
Click on the product you want. Click on 'buy now', then fill in your details. Enter your name, phone number, email and delivery/address details.

4. How long does it take to get the product once I order?
Delivery outside Nairobi will be done on the next day. Delivery within Nairobi will be on the same day.

5. How much do you charge for delivery?
Delivery charges vary depending on the location. Delivery is available countrywide, therefore charges will be different.

6. Do I need an account to place an order?
No, you don't need an account to place an order. However an account will allow you to make orders faster in the future, once you login your details are saved. With an account, you can also keep track of your orders.
";

$response["help"]=$help_text;


echo json_encode($response);