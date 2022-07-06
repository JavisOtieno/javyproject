<?php
// Be sure to include the file you've just downloaded
require_once('AfricasTalkingGateway.php');
// Specify your authentication credentials

require 'connect.inc.php';

$username   = "Javisotieno";
$apikey     = "d202356db965801d98ecc0421a039d71f85fe081840c5bd07338090a6cd92029";
// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)

//$recipients = "+254707641174,+254733YYYZZZ";


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

//leyn-nice promoter 79 deleted his account
$query='SELECT * FROM users WHERE user_id!=35 AND user_id!=79';

$query_run=mysqli_query($db_link,$query);

$rows=mysqli_num_rows($query_run);

while($row=mysqli_fetch_assoc($query_run)){

  $storename=$row['storename'];

// And of course we want our recipients to know what we really do
$message    = "JAVY: For images that you can use to promote your store www.$storename.av.ke, login to www.javy.co.ke/login.php and check under PROMOTE. Helpline: 0716545459. We're sorry for the earlier text messages with the wrong store names.";



  $number_without_0 = substr($row['phone'], 1);
  $final_number = "+254" . $number_without_0;
$recipients = $final_number;
try 
{ 
  // Thats it, hit send and we'll take care of the rest. 
  $results = $gateway->sendMessage($recipients, $message);
            
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
  echo "Encountered an error while sending: ".$e->getMessage();
}
// DONE!!! 

}