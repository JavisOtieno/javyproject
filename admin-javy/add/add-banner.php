<?php include '../header.php'; 

	echo '<br>';
	echo '<form method="GET" action="../submit/submit-banner.php" id="submitBannerForm">';

    echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';

	echo '<div class="form-group"><label>Banner Title:</label>';
	echo '<input class="form-control" required name="title" ></input></div>';

	echo '<div class="form-group"><label>Banner Image Link:</label>';
	echo '<input class="form-control" name="imagelink"></input></div>';

	echo '<div class="form-group"><label>Price:</label>';
	echo '<input class="form-control" required name="price" ></input></div>';

	echo '<div class="form-group"><label>Link:</label>';
	echo '<input class="form-control" required name="link" ></input></div>';

	echo '<div class="form-group"><label>Status:</label>';
	echo '<select required class="form-control" name="status">
  <option value="0" >Deleted</option>
  <option value="1" selected>Active</option>
  <option value="2" >To Activate</option>
</select></div>';

	echo '</div></div>';

	echo '<div class="col-md-6"><div style="margin-left:20px;">';

	echo '</div></div></div>';

	//echo '<div style="margin-top:10px"><label>Status:</label><br/></div>';
	//echo '<div><input name="status" value="'.$row['status'].'"></input></div>';

echo '<div id="messages"></div>';

	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-left: 20px;
    cursor: pointer;" type="submit" value="SUBMIT"></form>';



?>

<?php include '../footer.php'; ?>

 <script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){
	$("#messages").html("");

$("#submitOfferForm").unbind('submit').bind('submit',function(){


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
								window.location.href = "../offers.php";
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