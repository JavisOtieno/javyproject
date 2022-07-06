<?php include '../header-folder-up.php'; ?>

<form action="send-messages-contacts.php" method="POST" style="margin-left: 20px;width: 40%;">
<div class="form-group"><label>Store id or name</label>
<input class="form-control" name="store_id" id="store_id">
</div>
<div class="form-group"><label>Message to</label>
<select name="sendTo" id="sendTo" class="form-control">
  <option value="contacts" selected="selected" >Contact List</option>
  <option value="customers_contacts" >Customers and Contacts List</option>
  <option value="test" >Test to Promoter</option>

</select>
</div>
<div class="form-group"><label>Message</label>
<textarea class="form-control" name="message" id="message"></textarea>
</div>
<br/>
<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    cursor: pointer;" type="submit" value="SEND">
</form>
<?php

if (!(isset($_POST['message'])) && !(isset($_POST['store_id'])) ){


  echo "<span style='margin-left:20px;color:#C80909'>Enter Messages && Store id!!</span>";

}else{

$message=$_POST['message'];
$store_id=$_POST['store_id'];
$sendTo=$_POST['sendTo'];

if(!is_int($store_id)){
$query_store_id='SELECT user_id FROM users WHERE storename="'.$store_id.'"';
$query_store=mysqli_query($db_link,$query_store_id);
while($row_store=mysqli_fetch_assoc($query_store)){
	$store_id=$row_store['user_id'];
}
}

if($sendTo=='contacts'){


$query_contacts_messages='SELECT * FROM customer_numbers_for_messages WHERE store_id='.$store_id;
$query_contacts=mysqli_query($db_link,$query_contacts_messages);
while($row=mysqli_fetch_assoc($query_contacts)){
	# code...
$recipients = $row['phone'];

sendText($recipients,$message);

	}

}else if($sendTo=='test'){

$query_promoter_contact='SELECT phone FROM users WHERE user_id='.$store_id;
$query_contact=mysqli_query($db_link,$query_promoter_contact);
while($row=mysqli_fetch_assoc($query_contact)){
	$phonenumber=$row['phone'];
	$firstdigit=substr($phonenumber, 0, 1);

	if($firstdigit=='0'){
		$textableNumber = "+254".substr($phonenumber,1);
	}elseif($firstdigit=='7'){
		$textableNumber = "+254".$phonenumber;
	}elseif($firstdigit=='2'){
		$textableNumber = "+".$phonenumber;
	}elseif($firstdigit=="+"){
		$textableNumber = $phonenumber;
	}

	$recipients=$textableNumber;

	sendText($recipients,$message);

}

  
}else if($sendTo=="customers_contacts"){

$query_contacts_messages='SELECT * FROM customer_numbers_for_messages WHERE store_id='.$store_id;
$query_contacts=mysqli_query($db_link,$query_contacts_messages);
while($row=mysqli_fetch_assoc($query_contacts)){
	# code...
$recipients = $row['phone'];

sendText($recipients,$message);

}

$query_customers_messages='SELECT * FROM customers WHERE dealerid='.$store_id;
$query_customers=mysqli_query($db_link,$query_customers_messages);
while($row=mysqli_fetch_assoc($query_customers)){
	# code...
$phonenumber=$row['phone'];
	$firstdigit=substr($phonenumber, 0, 1);

	if($firstdigit=='0'){
		$textableNumber = "+254".substr($phonenumber,1);
	}elseif($firstdigit=='7'){
		$textableNumber = "+254".$phonenumber;
	}elseif($firstdigit=='2'){
		$textableNumber = "+".$phonenumber;
	}elseif($firstdigit=="+"){
		$textableNumber = $phonenumber;
	}

$recipients=$textableNumber;

sendText($recipients,$message);

}

}
}


function sendText($recipients,$message){

  // Be sure to include the file you've just downloaded
require_once('../AfricasTalkingGateway.php');
// Specify your authentication credentials
$username   = "Javisotieno";
$apikey     = "fc8597cbed40cda6a2e7651458aa02b44b5a0a2c148557b39d371e1efe28d6af";
// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)php
// Create a new instance of our awesome gateway class
$gateway    = new AfricasTalkingGateway($username, $apikey);
/*************************************************************************************
  NOTE: If connecting to the sandbox:
  1. Use "sandbox" as the username
  2. Use the apiKey generated from your sandbox application
     https://account.africastalking.com/apps/sandbox/settings/key
  3. Add the "sandbox" flag to the constructor
  $gateway  = new AfricasTalkingGateway($username, $apiKey, "sandbox");
**************************************************************************************/
// Any gateway error will be captured by our custom Exception class below, 
// so wrap the call in a try-catch block
try 
{ 
  // Thats it, hit send and we'll take care of the rest. 
  $results = $gateway->sendMessage($recipients, $message, "JAVY");
            
  foreach($results as $result) {
    // status is either "Success" or "error message"
    echo " Number: " .$result->number;
    echo " Status: " .$result->status;
    echo " MessageId: " .$result->messageId;
    echo " Cost: "   .$result->cost."\n";
  }
}
catch ( AfricasTalkingGatewayException $e )
{
  echo "<span style='margin-left:20px;'>Encountered an error while sending: ".$e->getMessage()."</span>";
}
// DONE!!! 
}

include '../footer.php'; 
