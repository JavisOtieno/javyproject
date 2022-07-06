<?php include 'header.php'; ?>

<form action="sendTextTest.php" method="POST" style="margin-left: 20px;width: 40%;">
<div class="form-group"><label>Phone</label>
<input type="text" class="form-control" name="phone" id="phone">
</input></div>
<br/>
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

if (!(isset($_POST['phone']))){


  echo "<span style='margin-left:20px;color:#C80909'>Enter phone number!!</span>";

}else{
  echo "<span style='margin-left:20px;'>phone number set. PHONE : ".$_POST['phone'].' <br/> MESSAGE : '.$_POST['message'].'</span><br/>';
  $recipients = $_POST['phone'];

  // Be sure to include the file you've just downloaded
require_once('AfricasTalkingGateway.php');
// Specify your authentication credentials
$username   = "Javisotieno";
$apikey     = "fc8597cbed40cda6a2e7651458aa02b44b5a0a2c148557b39d371e1efe28d6af";
// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)php

$storename="javis";

// And of course we want our recipients to know what we really do

$from = "JAVY";

if($_POST['message']){
  $message=$_POST['message'];
}else{
  $message="Test";
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
  echo "<span style='margin-left:20px;'>Encountered an error while sending: ".$e->getMessage()."</span>";
}
// DONE!!! 
  
}

include 'footer.php'; 
