<?php include '../header.php'; 

	echo '<br>';
	echo '<form method="GET" action="../submit/submit-enquiry.php" id="submitEnquiryForm">';

    echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';

    echo '<div class="form-group"><label>Enquiry Date:</label>';
	echo '<input class="form-control" id="enquiryDate" name="enquiryDate" type="date" ></input></div>';

	echo '<div class="form-group"><label>Enquiry Phone:</label>';
	echo '<input class="form-control" name="enquiryPhone" ></input></div>';

	echo '<div class="form-group"><label>Enquiry Item:</label>';
	echo '<input class="form-control" name="enquiryItem" ></input></div>';

	echo '<div class="form-group"><label>Enquiry Description:</label>';
	echo '<input class="form-control" name="enquiryDescription" ></input></div>';

	echo '<div class="form-group"><label>Enquiry Resolution Notes:</label>';
	echo '<input class="form-control" name="enquiryNotes" ></input></div>';



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
    cursor: pointer;" type="submit" value="SUBMIT"></form>';



?>

<?php include '../footer.php'; ?>

 <script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">

	Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
	});
	
	$(document).ready(function(){
	$("#messages").html("");

	
    $('#enquiryDate').val(new Date().toDateInputValue());


	

$("#submitEnquiryForm").unbind('submit').bind('submit',function(){


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
								window.location.href = "../enquiries.php";
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