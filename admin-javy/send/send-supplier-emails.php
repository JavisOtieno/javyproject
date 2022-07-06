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
	$count = $row['supplier_email_sent'];
}


if($count>254){
	echo "CAMPAIGN COMPLETE";
}else{


//query without unsubscribers
$query='SELECT * FROM suppliers WHERE id>'.$count.' AND id NOT IN (SELECT id FROM unsubscribe_list_suppliers) LIMIT 3';

//Test purposes Javis and Javy Technologies
//$query='SELECT * FROM suppliers WHERE id=1';

$query_run=mysqli_query($db_link,$query);


while($row=mysqli_fetch_assoc($query_run))
{


			ob_start();
			$username=$row['username'];
  			$website_visits=$row['web_visits'];
  			$supplier_id=$row['id'];
  			$email=$row['email'];


  			$query_orders='SELECT * FROM deals WHERE supplier_id='.$supplier_id;
			$query_run_orders=mysqli_query($db_link,$query_orders);
			$rows_orders=mysqli_num_rows($query_run_orders);



			$query_products='SELECT * FROM products WHERE supplier_id='.$supplier_id;
			$query_run_products=mysqli_query($db_link,$query_products);
			$rows_products=mysqli_num_rows($query_run_products);

			//$query_contact_messages='SELECT * FROM customer_contact_forms WHERE id='.$user_id;
			//$query_run_contact_messages=mysqli_query($db_link,$query_contact_messages);
			//$rows_contact_messages=mysqli_num_rows($query_run_contact_messages);

			$number_of_products=$rows_products;
  			$id=$supplier_id;
  			include("supplier-email-template.html");
  			$r = ob_get_clean();

  			$email_sendgrid = new \SendGrid\Mail\Mail(); 
			$email_sendgrid->setFrom("info@javy.co.ke", "Javy Technologies");
			$email_sendgrid->setSubject("Supplier Account Report | Post More Products and Sell More.");
			$email_sendgrid->addTo($email);
			

			$email_sendgrid->addContent("text/html",$r );


			echo $supplier_id."---".$username.'---'.$email.'<br/>';
			
				
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



$query='UPDATE last_saved_contact SET supplier_email_sent='.$supplier_id;

$query_run=mysqli_query($db_link,$query);

echo $query;

}


?>