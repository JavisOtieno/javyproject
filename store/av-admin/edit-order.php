<?php

include 'core.php';
require 'connect.inc.php';

if(isset($_GET['id'])){
	$id=$_GET['id'];
}

$query='SELECT * FROM deals WHERE id='.$id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){

	echo '<br>';
	echo '<form method="GET" action="submit-edit-order.php">';

	echo '<label>Deal Id:</label><br/>';
	echo '<input name="deal_id" value="'.$id.'" readonly></input></div>';

	echo '<div style="margin-top:10px"><label>Customer Name:</label><br/></div>';
	echo '<div><input name="name" value="'.$row['name'].'"></input></div>';

	echo '<div style="margin-top:10px"><label>Customer Phone:</label><br/>';
	echo '<input name="phone" value="'.$row['phone'].'"></input></div>';

	echo '<div style="margin-top:10px"><label>Customer Email:</label><br/></div>';
	echo '<div><input name="email" value="'.$row['email'].'"></input></div>';

	echo '<div style="margin-top:10px"><label>Delivery Details:</label><br/></div>';
	echo '<div><input name="delivery_details" value="'.$row['delivery_details'].'"></input></div>';

	echo '<div style="margin-top:10px"><label>Product Name:</label><br/></div>';
	echo '<div><input name="product_name" value="'.$row['product_name'].'" readonly></input></div>';

	echo '<div style="margin-top:10px"><label>Product Price:</label><br/></div>';
	echo '<div><input name="product_price" value="'.$row['product_price'].'" ></input></div>';

	echo '<div style="margin-top:10px"><label>Product Profit:</label><br/></div>';
	echo '<div><input name="product_profit" value="'.$row['product_profit'].'" ></input></div>';

	echo '<div style="margin-top:10px"><label>Product Id:</label><br/>';
	echo '<input name="product_id" value="'.$row['product_id'].'" readonly></input></div>';

	echo '<div style="margin-top:10px"><label>Supplier Id:</label><br/>';
	echo '<input name="supplier_id" value="'.$row['supplier_id'].'" readonly></input></div>';

	echo '<div style="margin-top:10px"><label>Customer Id:</label><br/>';
	echo '<input name="customer_id" value="'.$row['customer_id'].'" readonly></input></div>';

	echo '<div style="margin-top:10px"><label>Dealer Id:</label><br/>';
	echo '<input name="dealer_id" value="'.$row['dealer_id'].'" readonly></input></div>';

	$dealer_id=$row['dealer_id'];
	$query="SELECT * FROM users WHERE user_id='$dealer_id'";
	$query_run=mysqli_query($db_link,$query);

	while($row_store=mysqli_fetch_assoc($query_run)){
		echo "<br/> Store: ".$row_store['storename']."  Name: ".$row_store['firstname']." ".$row_store['lastname']."  Number:".$row_store['phone'];
	}

	echo '<div style="margin-top:10px"><label>Deal Date:</label><br/></div>';
	echo '<div><input name="date" value="'.$row['dealDate'].'" readonly></input></div>';

	echo '<div style="margin-top:10px"><label>Status:</label><br/></div>';
	//echo '<div><input name="status" value="'.$row['status'].'"></input></div>';

	if($row['status']==0){
	$selected0='selected';	
	}else{
		$selected0='';
	}

	if($row['status']==1){
	$selected1='selected';	
	}else{
		$selected1='';
	}

	if($row['status']==2){
	$selected2='selected';	
	}else{
		$selected2='';
	}


	echo '<div><select name="status">
  <option value="0" '.$selected0.' >Unprocessed</option>
  <option value="1" '.$selected1.'>Complete</option>
  <option value="2" '.$selected2.'>Cancelled</option>
</select></div>';







	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    cursor: pointer;" type="submit" value="UPDATE"></form>';


}

?>