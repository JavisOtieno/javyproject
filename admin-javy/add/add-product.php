<?php include '../header.php';  ?>

	
	<form id="submitProductForm" action="../submit/submit-product.php" method="GET">
	<div class="row"><div class="col-md-6"><div style="margin-left:20px;"><div class="form-group">
	<label>Product Name:</label><br/>
	<input type="text" class="form-control" name="productName" id="productName"/>
	</div>
	<div class="form-group">
	<label>Product Price:</label><br/>
	<input type="text" class="form-control" name="productPrice" id="productPrice"/>
	</div>
	<div class="form-group">
	<label>Product Cost:</label>
	<input type="text" class="form-control" name="productCost"/>
	</div>
	<div class="form-group">
	<label>Product Highlights:</label><br/>
	<pre><textarea class="form-control" rows="6" name="productHighlights"></textarea></pre>
	</div></div></div>

	<div class="col-md-6"><div style="margin-left:20px;"><div class="form-group">
	<label>Product Profit:</label><br/>
	<input type="text" class="form-control" name="productProfit"  id="productProfit"/></div>
	<div class="form-group">
	<label>Product Category:</label><br/>
	<select class="form-control" id="categoryName" name="categoryName" >
	<option value="" >~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT categories_id, categories_name,categories_slug, categories_status FROM categories WHERE categories_status = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[2]."'>".$row[1]."</option>";
								} // while

								//echo "<option value='other'>Other</option>";
								
				      	?>
				      	</select>
	</div>
	<div class="form-group">
	<label>Product Brand:</label><br/>
	<select class="form-control" id="brandName" name="brandName" >
				      
				      	<option value="">~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT brand_id, brand_name, brand_status,brand_slug FROM brands WHERE brand_status = 1 AND brand_category = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[3]."'>".$row[1]."</option>";
								} // while
								
								
				      	?>
				      </select></div>


				      	        <script type="text/javascript">

	        	 

	        	$('#categoryName').on('change', function(){
  				$('#categoryName').val();
  				$('#brandName').html('');


    
    					<?php 
    					$sql_category = "SELECT * FROM categories WHERE categories_status=1";
	        					$result = $connect->query($sql_category);
	        					$number_of_categories = mysqli_num_rows($result);
	        					$number_of_categories = $number_of_categories+1;

	        					echo "var brandsFromACategory = [];";
	        					echo "var brandCategoryArray = [];";

	        	      
	        			$count_category=1;
	        		    while($count_category<$number_of_categories){


	        		    	$sql_category_slug = "SELECT * FROM categories WHERE categories_id='$count_category'";
	        					$result_category_slug = $connect->query($sql_category_slug);

	        					while($row = $result_category_slug->fetch_array()) {
								$category_slug=$row['categories_slug'];
								} // while

	        		    	

	        		    	$sql = "SELECT * FROM brands WHERE brand_category='$count_category' AND brand_status=1";
	        					$result = $connect->query($sql);

	        					while($row = $result->fetch_array()) {
									echo "brandsFromACategory.push('".$row['brand_slug']."');";
								} // while

								echo "brandCategoryArray['".$category_slug."']=brandsFromACategory;";
								echo "brandsFromACategory = [];";

	        		    	$count_category++;
	        		    }

		
	        	      	?>



    if($('#categoryName').val()){
 
        $('#brandName').append('<option value="">~~SELECT~~</option>');
    	var categoryPicked=$('#categoryName').val();
    	
	        	 var brandPicked=brandCategoryArray[categoryPicked];     	
			    var arrayLength = brandPicked.length;
				for (var i = 0; i < arrayLength; i++) {
					brandLowercase=brandPicked[i];
					brandUppercase=brandLowercase.charAt(0).toUpperCase() + brandLowercase.substr(1);
				    $('#brandName').append('<option value='+brandLowercase+'>'+brandUppercase+'</option>');
				    //Do something
				}
				$('#brandName').append('<option value="other">Other</option>');
         
    }else{
    	$('#brandName').append('<option value="other">Other</option>');
    }
});

	        </script>
	
	
	<div class="form-group"><label>Product Status:</label><br/>
	<select name="productStatus" class="form-control">
		<option value="1" >Available</option>
		<option value="0" >NOT AVAILABLE</option>
		<option value="2" >Requested</option>
	</select></div>
	<div class="form-group"><label>Approval:</label><br/>
	<select name="approval" class="form-control">
		<option value="2" >Approved JAVY</option>
		<option value="1" >Approved Main</option>
		<option value="0" >NOT APPROVED</option>
	</select></div>
	<div class="form-group">
	<label>Product Featured:</label>
	<select name="productFeatured" class="form-control">
		<option value="0" >not featured</option>
		<option value="1" >FEATURED</option>
	</select></div></div></div></div>
<div id="messages"></div>
	<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    margin-left:20px;
    cursor: pointer;" type="submit" value="SUBMIT PRODUCT">

	</form>
	
<?php include '../footer.php'; ?>

<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){
	$("#messages").html("");

$("#submitProductForm").unbind('submit').bind('submit',function(){


			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/

			var productName=$("#productName").val();
			var productPrice=$("#productPrice").val();
			var productProfit=$("#productProfit").val();

			

			if(productName&&productPrice&&productProfit){

				
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
								window.location.href = "../../edit/edit-product.php?product_id="+response.id;
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
				
			
			}//if
		


			return false;
		});//submit categories form function

});
</script>