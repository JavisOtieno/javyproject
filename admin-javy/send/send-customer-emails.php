<?php

$base = dirname(dirname(__FILE__)); // now $base contains "app"

require($base."/email-sendgrid/sendgrid-php.php");

require $base.'/connect.inc.php';

$query_number_of_customers='SELECT * FROM customers';
$query_run=mysqli_query($db_link,$query_number_of_customers);
$rows=mysqli_num_rows($query_run);

//main query
$query='SELECT * FROM customers';


//users email to remove unsubscribers
//$query='SELECT * FROM users WHERE user_id NOT IN (SELECT user_id FROM unsubscribe_list)';

//batches of 50
$query_last_email_sent='SELECT * FROM last_saved_contact';
$query_run_last_email_sent=mysqli_query($db_link,$query_last_email_sent);

if($row=mysqli_fetch_assoc($query_run_last_email_sent)){
	$count = $row['customer_email_sent'];
}

if($count>3191){
	echo "CAMPAIGN COMPLETE";
		
}else{

$query='SELECT * FROM customers WHERE id>'.$count.' AND id NOT IN (SELECT id FROM unsubscribe_list_customers) LIMIT 18';
//Test purposes Javis and Javy Technologies
//$query='SELECT * FROM customers WHERE id=3';
$query_run=mysqli_query($db_link,$query);

while($row=mysqli_fetch_assoc($query_run))
	
{


			ob_start();
			$user_id=$row['id'];
			$promoter_id=$row['dealerid'];
			$email=$row['email'];
			$name=$row['name'];
			

			$query1='SELECT * FROM users WHERE user_id='.$promoter_id;
			$query_run1=mysqli_query($db_link,$query1);
			while($row1=mysqli_fetch_assoc($query_run1))
			{
				$storename=$row1['storename'];
  				$website_visits=$row1['web_visits'];
  				$promoter_phone = $row1['phone'];
				$promoter_email = $row1['email'];
			}
			

			$query_newsletter_products='SELECT * FROM newsletter_products';
			$query_run_newsletter_products=mysqli_query($db_link,$query_newsletter_products);
			while($row_newsletter_product=mysqli_fetch_assoc($query_run_newsletter_products)){
			//for each product
			
			$query_individual_product='SELECT * FROM products WHERE id='.$row_newsletter_product['product_id'];
			$query_run_individual_product=mysqli_query($db_link,$query_individual_product);

			//fetch image
			//fetch name
			//fetch price

			if($row_individual_product=mysqli_fetch_assoc($query_run_individual_product)){
				$product_name=$row_individual_product['name'];
				$product_image=$row_individual_product['image'];
				$product_price=$row_individual_product['price'];
			}

			$product_array[0]=$row_newsletter_product['product_id'];
			$product_array[1]=$product_name;
			$product_array[2]=str_replace('..', 'http://promote.javy.co.ke' , $product_image);
			$product_array[3]="KSh. ".number_format($product_price);

			$products_array[$row_newsletter_product['id']]=$product_array;

			//for the last product, fetch description as well
			$product_description=$row_newsletter_product['description'];


			}

			//print_r($products_array);


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



$query='UPDATE last_saved_contact SET customer_email_sent='.$user_id;

$query_run=mysqli_query($db_link,$query);

echo $query;

}


?>