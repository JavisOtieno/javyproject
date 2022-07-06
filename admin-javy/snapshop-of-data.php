

<?php

$base = dirname(dirname(__FILE__)); // now $base contains "app"


//require $base.'/connect.inc.php';

require 'connect.inc.php';


$query_number_of_orders='SELECT * FROM deals';
$query_run=mysqli_query($db_link,$query_number_of_orders);
$orders_number=mysqli_num_rows($query_run);

$query_number_of_orders='SELECT * FROM deals WHERE status=1';
$query_run=mysqli_query($db_link,$query_number_of_orders);
$succesful_orders_number=mysqli_num_rows($query_run);

$query_number_of_customers='SELECT * FROM customers';
$query_run=mysqli_query($db_link,$query_number_of_customers);
$customers_number=mysqli_num_rows($query_run);

$query_number_of_promoters='SELECT * FROM users';
$query_run=mysqli_query($db_link,$query_number_of_promoters);
$website_visits_number=0;
while($row=mysqli_fetch_assoc($query_run)){
	$website_visits_number=$website_visits_number+$row['web_visits'];
}
$promoters_number=mysqli_num_rows($query_run);

$query_number_of_suppliers='SELECT * FROM suppliers';
$query_run=mysqli_query($db_link,$query_number_of_suppliers);
$suppliers_number=mysqli_num_rows($query_run);

$query_number_of_products='SELECT * FROM products';
$query_run=mysqli_query($db_link,$query_number_of_products);
$products_number=mysqli_num_rows($query_run);

$query_number_of_messages='SELECT * FROM product_messages';
$query_run=mysqli_query($db_link,$query_number_of_messages);
$messages_number=mysqli_num_rows($query_run);

$query_number_of_messages='SELECT * FROM customer_emails';
$query_run=mysqli_query($db_link,$query_number_of_messages);
$emails_submitted_on_subscription_form_number=mysqli_num_rows($query_run);




$time_recorded=time();

$query='INSERT INTO snapshots_of_data VALUES(null,'.$time_recorded.','.$orders_number.','.$website_visits_number.','.$promoters_number.','.$customers_number.','.$succesful_orders_number.','.$messages_number.','.$products_number.','.$emails_submitted_on_subscription_form_number.')';

echo $query;

if($query_run=mysqli_query($db_link,$query)){
echo "works";
}else{
echo "fails";
}

?>