<?php include '../header.php'; 



if(isset($_GET['id'])){
	$id=$_GET['id'];
}

$query='SELECT * FROM withdrawals WHERE withdrawal_id='.$id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){

		$promoter_id=$row['user_id'];
	$query_store="SELECT * FROM users WHERE user_id='$promoter_id'";
	$query_run_store=mysqli_query($db_link,$query_store);

	while($row_store=mysqli_fetch_assoc($query_run_store)){
		echo "<div style='margin-left:20px;'> Store: ".$row_store['storename']."  Name: ".$row_store['firstname']." ".$row_store['lastname']."  Number:".$row_store['phone'].'</div>';
	}

	echo '<form method="GET" action="../submit/submit-edit-withdrawal.php" id="editWithdrawalForm">';

	echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';

	echo '<div class="form-group"><label>Withdrawal Id:</label>';
	echo '<input class="form-control" name="withdrawal_id" value="'.$id.'" readonly></input></div>';

	echo '<div class="form-group"><label>Withdrawal Amount:</label>';
	echo '<input class="form-control" name="amount" value="'.$row['amount'].'" ></input></div>';

	echo '<div class="form-group"><label>Promoter id:</label>';
	echo '<input class="form-control" name="promoter_id" value="'.$row['user_id'].'" readonly></input></div>';


	


	echo '<div class="form-group"><label>Method:</label>';
	echo '<input class="form-control" name="method" value="'.$row['method'].'" readonly></input></div>';


	echo '<div class="form-group"><label>Date:</label>';
	echo '<input class="form-control" name="date" value="'.date('d/m/Y \a\t h:iA',$row['date']).'" readonly></input></div>';

	echo '<div class="form-group"><label>Status:</label>';
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


	echo '<select class="form-control" name="status">
  <option value="0" '.$selected0.' >Unprocessed</option>
  <option value="1" '.$selected1.'>Complete</option>
  <option value="2" '.$selected2.'>Cancelled</option>
</select></div>';




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
    cursor: pointer;" type="submit" value="UPDATE"></form>';


}

?>

<?php include '../footer.php'; ?>

<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
  
  $(document).ready(function(){
  $("#messages").html("");

$("#editWithdrawalForm").unbind('submit').bind('submit',function(){


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
              setTimeout(function() {
              // Do something after 5 seconds
              $("#messages").html('');
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
