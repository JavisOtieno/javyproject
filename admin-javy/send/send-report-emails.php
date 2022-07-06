<?php
$base = dirname(dirname(__FILE__)); // now $base contains "app"

require($base."/email-sendgrid/sendgrid-php.php");

require $base.'/connect.inc.php';

$query_number_of_users='SELECT * FROM users';
$query_run=mysqli_query($db_link,$query_number_of_users);
$rows=mysqli_num_rows($query_run);

//users email to remove unsubscribers
//$query='SELECT * FROM users WHERE user_id NOT IN (SELECT user_id FROM unsubscribe_list)';

//batches of 50
$query_last_email_sent='SELECT * FROM last_saved_contact';
$query_run_last_email_sent=mysqli_query($db_link,$query_last_email_sent);
if($row=mysqli_fetch_assoc($query_run_last_email_sent)){
	$count = $row['email_sent'];
}

if($count>61497){
	echo "CAMPAIGN COMPLETE";
}else{


//query without unsubscribers
$query='SELECT * FROM users WHERE user_id>'.$count.' AND user_id NOT IN (SELECT user_id FROM unsubscribe_list) LIMIT 46';

//Test purposes Javis and Javy Technologies
//$query='SELECT * FROM users WHERE user_id=1 OR user_id=2';

$query_run=mysqli_query($db_link,$query);


while($row=mysqli_fetch_assoc($query_run))
{


			ob_start();
			$storename=$row['storename'];
  			$website_visits=$row['web_visits'];
  			$user_id=$row['user_id'];
  			$email=$row['email'];


  			$query_orders='SELECT * FROM deals WHERE id='.$user_id;
			$query_run_orders=mysqli_query($db_link,$query_orders);
			$rows_orders=mysqli_num_rows($query_run_orders);



			$query_product_messages='SELECT * FROM product_messages WHERE id='.$user_id;
			$query_run_product_messages=mysqli_query($db_link,$query_product_messages);
			$rows_product_messages=mysqli_num_rows($query_run_product_messages);

			$query_contact_messages='SELECT * FROM customer_contact_forms WHERE id='.$user_id;
			$query_run_contact_messages=mysqli_query($db_link,$query_contact_messages);
			$rows_contact_messages=mysqli_num_rows($query_run_contact_messages);

			$number_of_messages=$rows_contact_messages+$rows_product_messages;
  			$id=$user_id;
  			include("email-template.html");
  			$r = ob_get_clean();

  			$email_sendgrid = new \SendGrid\Mail\Mail(); 
			$email_sendgrid->setFrom("info@javy.co.ke", "Javy Technologies");
			$email_sendgrid->setSubject("www.".$storename.".av.ke's performance ");
			$email_sendgrid->addTo($email);
			

			$email_sendgrid->addContent("text/html",$r );


			echo $user_id."---".$storename.'---'.$email.'<br/>';
			
				
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



$query='UPDATE last_saved_contact SET email_sent='.$user_id;

echo $query;

$query_run=mysqli_query($db_link,$query);

}

?>