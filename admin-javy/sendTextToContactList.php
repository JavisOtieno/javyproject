<form action="sendTextTest.php" method="POST">
<label>Phone</label>
<input name="phone" id="phone">
</input>
</form>
<?php
// Be sure to include the file you've just downloaded
require_once('AfricasTalkingGateway.php');
// Specify your authentication credentials
$username   = "Javisotieno";
$apikey     = "fc8597cbed40cda6a2e7651458aa02b44b5a0a2c148557b39d371e1efe28d6af";
// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)php



$recipients = "
+254726403073,
+254706241914,
+254707641174,
+254745906905,
+254737851929,‬
+254795866416,
+254722440065,
+254773275822,
+254713164990,
+254795184659,
+254707794167,
+254715365980,
+254721952450,
+254721966663,
+254721609011,
+254726338791,
+254715812974,
+254729207170,
+254780441191,  
+254720916372,
+254713532823,
+254702536117,
+254703493464,
+254786410003,
+254706890052,
+254708250556,
+254721137798,
+254725237878,
+254716716842,
+254704224707,
+254725872734,
+254726401501,
+254711898530,
+254725297313,
+254725541410,
+254716000129,  
+254729595471,
+254712888995,
+254722214382,
+254723792825,
+254720399466,
+254711212826‬,
+254703900063,
+254727882470";
$storename="javis";

// And of course we want our recipients to know what we really do
$message    = "Happy Holidays!
Javy Technologies wishes you and your loved ones a Merry Christmas and a Happy New Year 2021. 

Thank you.";

$from = "JAVY";

if($_GET['m']){
  $message=$_GET['m'];
}
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
  $results = $gateway->sendMessage($recipients, $message, $from);
            
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