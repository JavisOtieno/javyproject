<?php include '../header.php'; 

if(isset($_GET['id'])){
	$id=$_GET['id'];
}

$query='SELECT * FROM users WHERE user_id='.$id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){

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

	echo '<br>';
	echo '<form method="GET" action="../submit/submit-edit-promoter.php" id="editPromoterForm">';

	echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;"><div class="form-group"><label>Promoter Id:</label><br/>';
	echo '<input class="form-control" name="promoter_id" value="'.$id.'" readonly></input></div>';

	echo '<div class="form-group"><label>Store Name:</label><br/>';
	echo '<input class="form-control" name="storename" value="'.$row['storename'].'"></input></div>';

  echo '<div class="form-group"><label>First Name:</label><br/>';
  echo '<input class="form-control" name="firstname" value="'.$row['firstname'].'"></input></div>';

  echo '<div class="form-group"><label>Last Name:</label><br/>';
  echo '<input class="form-control" name="lastname" value="'.$row['lastname'].'"></input></div>';

	echo '<div class="form-group"><label>Email:</label><br/>';
	echo '<input class="form-control" name="email" value="'.$row['email'].'"></input></div>';

	echo '<div class="form-group"><label>Phone Number:</label><br/>';
	echo '<input class="form-control" name="phone" value="'.$row['phone'].'"></input></div></div></div>';

	echo '<div class="col-md-6"><div style="
	">';

  echo '<div class="form-group"><label>Total Earnings to date:</label><br/>';
  echo '<input class="form-control" name="totalEarningsToDate" value="'.$totalEarningsToDate.'" readonly></input></div>';

  echo '<div class="form-group"><label>Supplier Registered :</label><br/>';
  echo '<input class="form-control" name="totalEarningsToDate" value="'.$row['supplier_registered_on'].'" readonly></input></div>';

  echo '<div class="form-group"><label>Earnings Available:</label><br/>';
  echo '<input class="form-control" name="totalEarningsAvailable" value="'.$totalEarningsAvailable.'" readonly></input></div>';

  echo '<div class="form-group"><label>Website Visits:</label><br/>';
  echo '<input class="form-control" name="website_visits" readonly value="'.$row['web_visits'].'"></input></div>';

  echo '<div class="form-group"><label>Total Earnings:</label><br/>';
  echo '<input class="form-control" name="total_earnings" readonly value="'.$totalEarningsToDate.'"></input></div>';

	echo '<div class="form-group"><label>Show Founder Details:</label><br/>';
	//echo '<div><input name="status" value="'.$row['status'].'"></input></div>';

	if($row['show_founder']==0){
	$selected0='selected';	
	}else{
		$selected0='';
	}

	if($row['show_founder']==1){
	$selected1='selected';	
	}else{
		$selected1='';
	}




	echo '<select class="form-control" name="show_founder">
  <option value="0" '.$selected0.' >Hide</option>
  <option value="1" '.$selected1.'>Show</option>
</select></div>';



echo '<div><label>Validation Status:</label><br/>';

	if($row['validation_status']==0){
	$selectstatus0='selected';	
	}else{
		$selectstatus0='';
	}

	if($row['validation_status']==1){
	$selectstatus1='selected';	
	}else{
		$selectstatus1='';
	}


echo '<select class="form-control" name="validation_status">
  <option value="0" '.$selectstatus0.' >Invalid</option>
  <option value="1" '.$selectstatus1.'>Valid</option>
</select></div></div></div></div>';

echo '<div id="messages"></div>';

	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    margin-left:20px;
    cursor: pointer;" type="submit" value="UPDATE"></form>';

         echo '<a href="../delete/delete-promoter.php?id='.$id.'" ><button style="background-color: #FF0000;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Delete Prommoter</button></a>

    ';

    echo '<a href="../delete/delete-promoter.php?id='.$id.'" ><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Delete Promoter</button></a>

    ';
        echo '<a href="../add/add-withdrawal.php?id='.$id.'"><button style="background-color: #0079D7;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Withdraw Earnings</button></a>

    ';

            echo '<a target="_blank" href="http://promote.javy.co.ke/bypass.php?id='.$id.'"><button style="background-color: #FF9900;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Login</button></a>

    ';

            echo '<a href="../orders.php?type=promoter&id='.$id.'"><button style="background-color: #DB7BFF;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    display:inline-block;
    margin-left:20px;
    cursor: pointer;" >View Promoters Orders</button></a>';


           echo '<a href="../withdrawals.php?id='.$id.'"><button style="background-color: #DB7BFF;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    display:inline-block;
    margin-left:20px;
    cursor: pointer;" >View Promoter Withdrawals</button></a>';




}

?>

<?php include '../footer.php'; ?>

<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
  
  $(document).ready(function(){
  $("#messages").html("");

$("#editPromoterForm").unbind('submit').bind('submit',function(){


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
              setTimeout(function() {
              // Do something after 5 seconds
              $("#messages").html('');
              }, 1000);

              //remove the messages after 10 seconds

              

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
