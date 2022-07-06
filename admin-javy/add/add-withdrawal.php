<?php  include '../header.php'; 

if(isset($_GET['id'])){
	$id=$_GET['id'];
}

$query='SELECT * FROM withdrawals WHERE withdrawal_id='.$id.'';

$query_run=mysqli_query($db_link,$query);




$sqlearnings= "SELECT product_profit FROM deals WHERE status=1 AND dealer_id=$id";
$query_run2=mysqli_query($db_link,$sqlearnings);
$totalRevenue=0;
while($row2=mysqli_fetch_assoc($query_run2)){
	$totalRevenue += $row2['product_profit'];
}

$sqlwithdrawals="SELECT amount FROM withdrawals WHERE user_id='$id' AND (status=0 OR status=1)";
$query_run3=mysqli_query($db_link,$sqlwithdrawals);
$totalWithdrawals=0;
while($row3=mysqli_fetch_assoc($query_run3)){
	$totalWithdrawals +=$row3['amount'];
}

$totalEarningsToDate=$totalRevenue;
$totalEarningsAvailable=$totalRevenue-$totalWithdrawals;




    echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';
	
	echo '<form method="GET" action="../submit/submit-withdrawal.php" id="submitWithdrawalForm">';

	echo '<div class="form-group"><label>Promoter Id:</label>';
	echo '<input  class="form-control" name="user_id" value="'.$id.'" readonly></input></div>';

	echo '<div class="form-group"><label>Amount to withdraw:</label>';
	echo '<input  class="form-control" name="amount" value="'.$totalEarningsAvailable.'" readonly></input></div>';

	echo '<div class="form-group"><label>Payment Method:</label><br/>';
	echo '<select  class="form-control" name="method">
  <option value="Mpesa">Mpesa</option>
  <option value="Cash" >Cash</option>
  <option value="Airtel Money">Airtel Money</option>
</select></div>';

	echo '<div class="form-group"><label>Status:</label>';
	echo '<select  class="form-control" name="status">
  <option value="0" >Unprocessed</option>
  <option value="1" selected>Complete</option>
  <option value="2" >Cancelled</option>
</select></div>';

echo '<div id="messages"></div>';

	//echo '<div style="margin-top:10px"><label>Status:</label><br/></div>';
	//echo '<div><input name="status" value="'.$row['status'].'"></input></div>';



	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    cursor: pointer;" type="submit" value="SUBMIT"></div></div></div></form>';



?>

<?php include '../footer.php'; ?>


 <script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){
	$("#messages").html("");

$("#submitWithdrawalForm").unbind('submit').bind('submit',function(){


			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/

				
				var form =$(this);

				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response){

					
						if(response.success == true){
						
						
							//reload the manage member datatable
							//manageCategoriesTable.ajax.reload(null,false);

							//reset the form text
							//$("#submitOrderForm")[0].reset();
						

							$("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');

							//remove the messages after 10 seconds

							setTimeout(function () {
								window.location.href = "../withdrawals.php";
							}, 1000);
							

						}//if */
						else if(response.success == false){

						
						//console.log(response);
							//reload the manage member datatable
							//manageCategoriesTable.ajax.reload(null,false);

							//reset the form text
						

							$("#messages").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');

							//remove the messages after 10 seconds
							

						}//if */
					} //success
				});//ajax
				
			
			
		


			return false;
		});//submit categories form function

});
</script>