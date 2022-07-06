<?php

require_once 'php_action/db_connect.php';
require("email-sendgrid/sendgrid-php.php");

$sqlUsers="SELECT * FROM users WHERE validation_status=0";

$connect->query($sqlUsers);

$result=$connect->query($sqlUsers);
while($row=$result->fetch_assoc()){


				$email=$row['email'];
				$firstname=$row['firstname'];

				$validation_code=$row['validation_code'];
				// If not using Composer, uncomment the above line

				echo $email.' '.$firstname.'<br/>';

				$email_sendgrid = new \SendGrid\Mail\Mail(); 
				$email_sendgrid->setFrom("info@javy.co.ke", "Javy Technologies");
				$email_sendgrid->setSubject("Confirm Email.");
				$email_sendgrid->addTo($email, $firstname);
				$email_sendgrid->addContent("text/plain", "Hello, ".$firstname.". Thank you for signing up on Javy. Click on the following link to confirm your account. http://promote.javy.co.ke/confirm-email.php?code=".$validation_code );
				//$email_sendgrid->addContent("text", "<strong>and easy to do anywhere, even with PHP</strong>");
				$sendgrid = new \SendGrid('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');
				try {
				    $response = $sendgrid->send($email_sendgrid);
				     //print $response->statusCode() . "\n";
				     //print_r($response->headers());
				     //print $response->body() . "\n";
				} catch (Exception $e) {
				    //echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
}

?>