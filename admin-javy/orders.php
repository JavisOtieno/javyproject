<?php include('header.php'); ?>

<?php



require 'connect.inc.php';



$query='SELECT * FROM deals ORDER BY id DESC';
$query_run=mysqli_query($db_link,$query);

$rows=mysqli_num_rows($query_run);

$query_succesful_orders='SELECT * FROM deals WHERE status=1 ORDER BY id DESC';
$query_unsuccesful_orders="SELECT * FROM deals WHERE status=2 ORDER BY id DESC";
$query_processing_orders="SELECT * FROM deals WHERE status=0 ORDER BY id DESC";

$query_succesful_run=mysqli_query($db_link,$query_succesful_orders);
$rows_successful=mysqli_num_rows($query_succesful_run);
$query_unsuccesful_run=mysqli_query($db_link,$query_unsuccesful_orders);
$rows_unsuccesful=mysqli_num_rows($query_unsuccesful_run);
$query_processing_run=mysqli_query($db_link,$query_processing_orders);
$rows_processing=mysqli_num_rows($query_processing_run);


if(isset($_GET['type'])){
	$type=$_GET['type'];

	if($type=="complete"){
$query_run=$query_succesful_run;
}
else if($type=="processing"){
$query_run=$query_processing_run;
}
else if($type=="unsuccesful"){
$query_run=$query_unsuccesful_run;
}else if($type=="promoter")
{
$promoter_id=$_GET['id'];
$query_promoter="SELECT * FROM deals WHERE dealer_id=".$promoter_id." ORDER BY id DESC";
$query_promoter_run=mysqli_query($db_link,$query_promoter);
$query_run=$query_promoter_run;
}
}

if($userId == 1){
echo "Number of Orders: ".$rows;

echo "  Successful Orders: ".$rows_successful."  Unsuccesful Orders: ".$rows_unsuccesful."  Processing Orders: ".$rows_processing;
}


echo '<br/><br/<div style="display:inline-block;margin:10px;"><a href="orders.php"><button>All Orders</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="orders.php?type=complete"><button>Complete Orders</button></a></div>';


echo '<div style="display:inline-block;margin:10px;"><a href="orders.php?type=processing"><button>Processing Orders</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="orders.php?type=unsuccesful"><button>Unsuccesful Orders</button></a></div>';



echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr>
<td><strong>ID</strong></td>
<td><strong>Website</strong></td>
<td><strong>Product Name</strong></td>';
if($userId==1){
echo '<td><strong>Product Profit</strong></td>';
}
echo
'<td><strong>Customer Phone</strong></td>
<td><strong>View/Edit</strong></td>
<td><strong>Invoice</strong></td>
<td><strong>Status</strong></td>';
if($userId==1){
echo '<td><strong>Payment</strong></td>';
}
echo 
'<td><strong>Date</strong></td>
';
if($userId==1){
echo '<td><strong>Profit Made</strong></td>';
}
echo '</tr>
</thead><tbody>';


$total_profit=0;
$total_commissions_paid_out=0;
$count=0;

while($row=mysqli_fetch_assoc($query_run)){

	if ($row['status']==1){
		$status='complete';
	}elseif ($row['status']==0) {
		$status='processing';
	}elseif ($row['status']==2) {
		$status='cancelled';
	}
	if($count==0){
		echo "<tr class='table-primary'>";
	}
	else if($count==1){
		echo '<tr class="table-secondary">';
	}
	else if($count==2){
		echo '<tr class="table-success">';
	}else if($count==3){
		echo '<tr class="table-danger">';
	}else if($count==4){
		echo '<tr class="table-warning">';
	}
	else if($count==5){
	echo '<tr class="table-info">';
	}


$promoter_id=$row['dealer_id'];
$supplier_id=$row['supplier_id'];
$order_by_dealer=$row['order_by_dealer'];

//if order was made on a supplier's website

if($order_by_dealer==5)
{
$query_suppliers="SELECT * FROM suppliers WHERE id='".$supplier_id."'";
$query_suppliers_run=mysqli_query($db_link,$query_suppliers);

while($row_supplier=mysqli_fetch_assoc($query_suppliers_run)){
	$storename=$row_supplier['username'].'<strong>-SUPP</strong>';

}
}
else
{
$query_promoters="SELECT * FROM users WHERE user_id='".$promoter_id."'";
$query_promoters_run=mysqli_query($db_link,$query_promoters);

while($row_promoter=mysqli_fetch_assoc($query_promoters_run)){
	$storename=$row_promoter['storename'];
}
}


echo '<td>'.$row['id'].'</td>
<td>'.$storename.'</td>
<td>'.$row['product_name'].'</td>';

if($userId==1){
echo '<td>'.$row['product_profit'].'</td>';
}
echo
'<td>'.$row['phone'].'</td>
<td><a href="edit/edit-order.php?id='.$row['id'].'"><button>view/edit</button></a></td>
<td><a href="view-invoice.php?id='.$row['id'].'"><button>Invoice</button></a></td>
<td>'.$status.'</td>';

$count++;

if($count==6){
	$count=0;
}

if($userId==1){
echo '<td>';

  if($row['status']==1){ 
$query_payment='SELECT * FROM supplier_payments WHERE order_id='.$row['id'];

$query_run_payment=mysqli_query($db_link,$query_payment);

if(mysqli_num_rows($query_run_payment)>0){


if($row_payment=mysqli_fetch_assoc($query_run_payment)){

	$status=$row_payment['status'];

	if($status==0){
		echo "Payment Cancelled";
	}
	elseif($status==1){
		echo "Payment Complete";
	}else{
		echo "Payment Processing";
	}
}

}else{
	echo '<a href="add/add-payment.php?id='.$row['id'].'" ><button style="background-color: #FF9900;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer; ">Make payment</button></a>';
}

}else{
	echo "---";
} 

echo "</td>";
}

echo '<td>'.date('d/m/Y \a\t h:iA',$row['dealDate']).'</td>';

//present profit per deal

$profit_on_deal=$row['product_price']-$row['cost']-$row['product_profit']-65;

if($userId==1){
echo '<td>';

if($row['status']==1){
	echo $profit_on_deal;
	$total_profit=$total_profit+$profit_on_deal;
	$total_commissions_paid_out=$total_commissions_paid_out+$row['product_profit'];
}

echo '</td>';
}
echo '</tr>';




}

echo '</tbody></table>';

echo "<br/><br/>TOTAL PROFIT : ".$total_profit."";
echo "<br/><br/>TOTAL COMMISIONS PAID OUT : ".$total_commissions_paid_out."";

include 'footer.php'; 

?>