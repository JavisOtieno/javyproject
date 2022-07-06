

<?php

$base = dirname(dirname(__FILE__)); // now $base contains "app"

require($base."/email-sendgrid/sendgrid-php.php");

require $base.'/connect.inc.php';


$query_number_of_customers='SELECT * FROM customer_emails';
$query_run=mysqli_query($db_link,$query_number_of_customers);
$rows=mysqli_num_rows($query_run);

echo 'Customer Emails:'.$rows.'<br/>';

$query_number_of_customers='SELECT * FROM customer_emails WHERE email NOT IN (SELECT email FROM customers)';
$query_run=mysqli_query($db_link,$query_number_of_customers);
$rows=mysqli_num_rows($query_run);

echo 'Customer Filtered Emails:'.$rows.'<br/>';

//main query
$query='SELECT * FROM customers';


//users email to remove unsubscribers
//$query='SELECT * FROM users WHERE user_id NOT IN (SELECT user_id FROM unsubscribe_list)';

//batches of 50
$query_last_email_sent='SELECT * FROM last_saved_contact';
$query_run_last_email_sent=mysqli_query($db_link,$query_last_email_sent);
if($row=mysqli_fetch_assoc($query_run_last_email_sent)){
	$count = $row['customer_email_subscriber_email_sent'];
}


//$query = 'SELECT * FROM customer_emails WHERE id>'.$count.' AND email NOT IN (SELECT email FROM customers) AND id NOT IN (SELECT id FROM unsubscribe_list_subscribers) LIMIT 4';
//Test purposes Javis
$query = 'SELECT * FROM customer_emails WHERE email ="javisotieno@gmail.com"';
$query_run=mysqli_query($db_link,$query);

while($row=mysqli_fetch_assoc($query_run))
	
{


			ob_start();
			$user_id=$row['id'];
			$promoter_id=$row['dealer_id'];
			$email=$row['email'];
			

			$query1='SELECT * FROM users WHERE user_id='.$promoter_id;
			$query_run1=mysqli_query($db_link,$query1);
			while($row1=mysqli_fetch_assoc($query_run1))
			{
				$storename=$row1['storename'];
  				$website_visits=$row1['web_visits'];
  				$promoter_phone = $row1['phone'];
				$promoter_email = $row1['email'];
			}
			

			//$count = $row1['customer_email_sent'];

			$number_of_messages=$rows_contact_messages+$rows_product_messages;
  			$id=$user_id;

  			include("customer-newsletter-2.html");
  			$r = ob_get_clean();

  			$email_sendgrid = new \SendGrid\Mail\Mail(); 
			$email_sendgrid->setFrom("info@javy.co.ke", ucfirst($storename) );
			$email_sendgrid->setSubject(" Amazing deals on our online store! Shop Now ");
			$email_sendgrid->addTo($email);
			/*$email_sendgrid->addContent("text/plain", "
				Find this month's images on www.".$storename.".av.ke on http://www.javy.co.ke/promote-images.php?id=".$user_id."&o1=5&o2=6&o3=7&o4=8
				" );
			*/

			$email_sendgrid->addContent("text/html",$r );


			echo $user_id."---".$storename.'---'.$name.'---'.$email.'<br/>';
			
			
			$sendgrid = new \SendGrid('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');

		
			try {
				    $response = $sendgrid->send($email_sendgrid);
				     print $response->statusCode() . "\n";
				     print_r($response->headers());
				     print $response->body() . "\n";
				
				} catch (Exception $e) {
				    echo 'Caught exception: ',  $e->getMessage(), "\n";
				   
				}
				

			

				
				

				

		}


$query='UPDATE last_saved_contact SET customer_email_subscriber_email_sent='.$user_id;

$query_run=mysqli_query($db_link,$query);

?>