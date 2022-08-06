				<?php
				require_once('../AfricasTalkingGateway.php');
				// Specify your authentication credentials
				$username   = "Javisotieno";
				$apikey     = "fc8597cbed40cda6a2e7651458aa02b44b5a0a2c148557b39d371e1efe28d6af";
				// Specify the numbers that you want to send to in a comma-separated list
				// Please ensure you include the country code (+254 for Kenya in this case)

				if (isset($_GET['phone'])){
				$promoter_phone=$_GET['phone'];
				}

				function formatPhoneNumber($phone){
					$firstdigit=substr($phone, 0, 1);

				if($firstdigit=='0'){
				  $recipient = "+254".substr($phone,1);
				}elseif($firstdigit=='7'){
				  $recipient= "+254".$phone;
				}elseif($firstdigit=='2'){
				  $recipient = "+".$phone;
				}elseif($firstdigit=="+"){
				  $recipient = $phone;
				}
				return $recipient;
				}

				$recipient_promoter = formatPhoneNumber($promoter_phone);

				//$recipients = "+254707641174,+254733YYYZZZ";

				// And of course we want our recipients to know what we really do
				$code = rand(1000,9999);

				$message_promoter = $code." is your verification code. Valid for 5 minutes";

				$gateway    = new AfricasTalkingGateway($username, $apikey);

				$from = "JAVY";

				try 
				{ 
				  // Thats it, hit send and we'll take care of the rest. 
				  $results_promoter = $gateway->sendMessage($recipient_promoter, $message_promoter, $from);
				            
				  foreach($results_promoter as $result) {
				    // status is either "Success" or "error message"
				    //echo " Number: " .$result->number;
				    //echo " Status: " .$result->status;
				    //echo " MessageId: " .$result->messageId;
				    //echo " Cost: "   .$result->cost."\n";
				  }
				   // Thats it, hit send and we'll take care of the rest. 
				
				}
				catch ( AfricasTalkingGatewayException $e )
				{
				  //echo "Encountered an error while sending: ".$e->getMessage();
				}