<?php 

include 'connect.inc.php';
session_start();


$product_id=$_GET['id'];
$supplier_id=$_GET['supplier_id'];
$variable_name=$_GET['variable_name'];
$variable_price=$_GET['variable_price'];


   $sql="SELECT * FROM products WHERE id='".$product_id."'";
   //echo $sql;
   $result=$connect->query($sql);

    if($row=mysqli_fetch_assoc($result)){


    		if ($supplier_id!=$row['supplier_id']&&$row['supplier_id']!=0){
					$query_more_suppliers= "SELECT * FROM more_suppliers WHERE supplier_id=$supplier_id AND product_id=".$product_id;
					//echo $query_more_suppliers;
					$query_run_more_suppliers=mysqli_query($db_link,$query_more_suppliers);
					if($row2=mysqli_fetch_assoc($query_run_more_suppliers)){

						if($row2['price']!=0){
							$price_multiple=$row2['price'];
						}else{
							$price_multiple=$row['price'];
						}
						if($row2['profit']!=0){
							$profit_multiple=$row2['profit'];
						}else{
							$profit_multiple=$row['profit'];
						}
						if($row2['cost']!=0){
							$cost_multiple=$row2['cost'];
						}else{
							$cost_multiple=$row['cost'];
						}
					}else{
					$price_multiple=$row['price'];
					$profit_multiple=$row['profit'];	
					$cost_multiple=$row['cost'];	
					}
				}else{
					$price_multiple=$row['price'];
					$profit_multiple=$row['profit'];	
					$cost_multiple=$row['cost'];			
				}

    $product_profit = $profit_multiple;
	$product_price = $price_multiple;
	$product_cost = $cost_multiple;
	$product_name = $row['name'].' '.$variable_name;

	if(!empty($variable_price)){
		$product_price=$variable_price;
	}

    }


$product_quantity=1;

$cart_product=[$product_id,$product_quantity];

if (isset($_SESSION['cart_products'])){

	$_SESSION['cart_products'][$product_id]['quantity']=$product_quantity;
	$_SESSION['cart_products'][$product_id]['name']=$product_name;
	$_SESSION['cart_products'][$product_id]['price']=$product_price;
	$_SESSION['cart_products'][$product_id]['cost']=$product_cost;
	$_SESSION['cart_products'][$product_id]['profit']=$product_profit;

}else{

	$_SESSION['cart_products'][$product_id]['quantity']=$product_quantity;
	$_SESSION['cart_products'][$product_id]['name']=$product_name;
	$_SESSION['cart_products'][$product_id]['price']=$product_price;
	$_SESSION['cart_products'][$product_id]['cost']=$product_cost;
	$_SESSION['cart_products'][$product_id]['profit']=$product_profit;
	
}





?>