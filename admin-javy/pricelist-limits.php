<?php include 'header.php'; 

	echo '<br>';
	echo '<form method="GET" action="pricelists.php" id="submitBrandForm">';

    echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';

	echo '<div class="form-group"><label>Starting:</label>';
	echo '<input class="form-control" name="startPrice" ></input></div>';

	echo '<div class="form-group"><label>Ending:</label>';
	echo '<input class="form-control" name="endPrice" ></input></div>';

	echo '<div class="form-group"><label>Product Category:</label><br/>
	<select class="form-control" id="category" name="category">
	<option value="">~~SELECT~~</option>';
		
				      	$sql = "SELECT categories_id, categories_name,categories_slug, categories_status FROM categories WHERE categories_status = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[2]."'>".$row[1]."</option>";
								
								} // while

								echo "<option value='other'>Other</option>";
								
		echo '</select></div>';

		echo '<label>Product Brand:</label><br/>
	<select class="form-control" id="brand" name="brand" >
				      
				      	<option value="">~~SELECT~~</option>';

				      	$sql = "SELECT brand_id, brand_name, brand_status,brand_slug FROM brands WHERE brand_status = 1 AND brand_category = 1";
							$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[3]."'>".$row[1]."</option>";
								} // while
								
								
				      echo '</select></div>';

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

<?php include 'footer.php'; ?>

 <script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
/*	
	$(document).ready(function(){
	$("#messages").html("");

$("#submitBrandForm").unbind('submit').bind('submit',function(){




				
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
								window.location.href = "../categories-and-brands.php";
							}, 1000);
							

						}//if 
						else if(response.success == false){

						
						//console.log(response);
							//reload the manage member datatable
							//manageCategoriesTable.ajax.reload(null,false);

							//reset the form text
						
							$("#messages").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');

							//remove the messages after 10 seconds
							

						}//if
					} //success
				});//ajax
				
			
			
		


			return false;
		});//submit categories form function

});

	*/
</script>