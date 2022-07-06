<?php

require("../email-sendgrid/sendgrid-php.php");

require '../connect.inc.php';

$query='SELECT * FROM users WHERE user_id>431 AND user_id<458';
$query='SELECT * FROM users WHERE user_id=1';

//Test purposes Javis and Javy Technologies

//users email to remove unsubscribers
//$query='SELECT * FROM users WHERE user_id NOT IN (SELECT user_id FROM unsubscribe_list)';


$query_run=mysqli_query($db_link,$query);

$rows=mysqli_num_rows($query_run);

while($row=mysqli_fetch_assoc($query_run)){

  			$storename=$row['storename'];
  			$website_visits=$row['web_visits'];
  			$user_id=$row['user_id'];
  			$random_hash=$row['validation_code'];
  			$email=$row['email'];
  			$firstname=$row['firstname'];



				$email_sendgrid = new \SendGrid\Mail\Mail(); 
				$email_sendgrid->setFrom("info@javy.co.ke", "Javy Technologies");
				$email_sendgrid->setSubject("Confirm Email.");
				$email_sendgrid->addTo($email, $firstname);
				$email_sendgrid->addContent("text/plain", "Hello, ".$firstname.". Thank you for signing up on Javy. Click on the following link to confirm your account. http://promote.javy.co.ke/confirm-email.php?code=".$random_hash );
				$email_sendgrid->addContent(
				    "text", "<strong>and easy to do anywhere, even with PHP</strong>"
				);
				$sendgrid = new \SendGrid('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');
				try {
				    $response = $sendgrid->send($email_sendgrid);
				     print $response->statusCode() . "\n";
				     print_r($response->headers());
				     print $response->body() . "\n";
				} catch (Exception $e) {
				    //echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
		

		}


?>