<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>

<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Product</li>
		</ol>


		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-ruble"></i> Products</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<form action="php_action/changeProducts.php" method="post" class="form-horizontal" id="changeProductsForm" class="div-action pull pull-left" style="width:70%;" >
					<fieldset>
						<legend>Select Products</legend>

						<div class="changeProductsMessages"></div>			

						<div class="form-group">
					    <label for="products" class="col-sm-4 control-label">Products on Website</label>
					    <div class="col-sm-8">
					     
					      <select class="form-control" id="products" name="products" placeholder="products" value="<?php echo $result['products']; ?>" >
					      	<option value="0" <?php if($products_type==0){echo 'selected';}?> > Your Products  </option>
							  <option value="1" <?php if($products_type==1){echo 'selected';}?>  > Javy Products & Your Products </option>
							</select>
					      	
					     
					    </div>
					  </div>

					   <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $userId; ?>" /> 
					      <button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeDisplayProductsBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					    </div>
					  </div>		

					</fieldset>
				</form>

				
				<div class="div-action pull pull-right" style="padding-bottom:20px;"><!--manageProductTable-->
					<button class="btn btn-default button1" data-toggle="modal" id="addProductModalBtn" data-target="#addProductModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add New Product </button>
				</div> <!--div-action-->	
					
				
				<table class="table" id="manageProductTable">
					<thead>
						<tr>
							<th style="width:10%;">Photo</th>							
							<th>Product Name</th>
							<th>Edit</th>
							<th>Customer Price</th>		
							<th>Wholesale Price</th>	
							<th>Commission</th>					
							<th>Category</th>
							<th>Brand</th>
							<!--NO NEED FOR STATUS AND OPTIONS-->
							<th>Status</th>
							<th style="width:15%;">Remove</th>
						</tr>
					</thead>
				</table>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->



<!-- add product -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

    	<form class="form-horizontal" id="submitProductForm" action="php_action/createProduct.php" method="POST" enctype="multipart/form-data">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Product</h4>
	      </div>



	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      	<div id="add-product-messages"></div>

	      	<!--<div class="form-group">
	        	<label for="productImage" class="col-sm-3 control-label">Product Image: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
					    //the avatar markup
							<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
					    <div class="kv-avatar center-block">					        
					        <input type="file" class="form-control" id="productImage" placeholder="Product Name" name="productImage" class="file-loading" style="width:auto;"/>
					    </div>
				      
				    </div>
	        </div>  //form-group-->	



	        <div class="form-group">
	        	<label for="productName" class="col-sm-3 control-label">Product Name: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="productName" placeholder="Product Name" name="productName" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	



	         <div class="form-group">
	        	<label for="price" class="col-sm-3 control-label">Selling(Customer) Price </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="price" placeholder="Price" name="price" autocomplete="off" onkeyup="numbersOnly(this)">
				    </div> 
				    </div> 
			<div id="cost-price-error" class="col-sm-offset-4 col-sm-8"></div>

	        <div class="form-group">
	        	<label for="cost" class="col-sm-3 control-label">Wholesale Price </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="cost" placeholder="Cost" name="cost" autocomplete="off" onkeyup="numbersOnly(this)">
				    </div> 
				    </div> 

			<div class="form-group">
			        	<label for="Commission" class="col-sm-3 control-label">Commission: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="commission" placeholder="Commission" name="commission" autocomplete="off" onkeyup="numbersOnly(this)">
						    </div>
			        </div> <!-- /form-group-->



		   <div class="form-group">
	        	<label for="shortDescription" class="col-sm-3 control-label">Short Description: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">				     
				       <textarea type="text" class="form-control" id="shortDescription" placeholder="Short description" name="shortDescription" rows="3" autocomplete="off" ></textarea>
				    </div> 
				</div>

	        <!--
	        <div class="form-group">
	        	<label for="quantity" class="col-sm-3 control-label">Quantity: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="quantity" placeholder="Quantity" name="quantity" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	        	 

	        <!--<div class="form-group">
	        	<label for="rate" class="col-sm-3 control-label">Rate: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="rate" placeholder="Rate" name="rate" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	



	         <div class="form-group">
	        	<label for="categoryName" class="col-sm-3 control-label">Category Name: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select type="text" class="form-control" id="categoryName" placeholder="Product Name" name="categoryName" >
				      	<option value="">~~SELECT~~</option>
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
	        </div> <!-- /form-group-->	

	        




	        <div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label">Brand Name: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="brandName" name="brandName">
				      	/*
				      	<option value="">~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT brand_id, brand_name, brand_status,brand_slug FROM brands WHERE brand_status = 1 AND brand_category = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[3]."'>".$row[1]."</option>";
								} // while
								
								
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	

	        	   <div class="form-group">
	        	<label for="productImage" class="col-sm-3 control-label">Product Image: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      You'll get to upload your product image later
				    </div> 
				</div>




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



	       				        	         	       

	        <!--status to be set automatically
	        <div class="form-group">
	        	<label for="productStatus" class="col-sm-3 control-label">Status: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="productStatus" name="productStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Available</option>
				      	<option value="2">Not Available</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	         	        
	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
	        
	        <button type="submit" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
	      </div> <!-- /modal-footer -->	      
     	</form> <!-- /.form -->	     
    </div> <!-- /modal-content -->    
  </div> <!-- /modal-dailog -->
</div> 
<!-- /add categories -->




<!-- edit categories brand -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	    	
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Product</h4>
	      </div>
	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      	<div class="div-loading">
	      		<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
	      	</div>

	      	<div class="div-result">

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				  	<li role="presentation" class="active" ><a href="#productInfo" aria-controls="profile" role="tab" data-toggle="tab">Product Info</a></li> 
				    <li role="presentation" ><a href="#photo" aria-controls="home" role="tab" data-toggle="tab">Photo</a></li>
				       
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">

				  	
				   
				    <!-- product image -->
				    <div role="tabpanel" class="tab-pane active" id="productInfo">
				    	<form class="form-horizontal" id="editProductForm" action="php_action/editProduct.php" method="POST">				    
				    	<br />

				    	<div id="edit-product-messages"></div>

				    	<input name="brandHolder"  type="hidden" id="brandHolder" value="" />

				    	<div class="form-group">
			        	<label for="editProductName" class="col-sm-3 control-label">Product Name: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="editProductName" placeholder="Product Name" name="editProductName" autocomplete="off" >
						    </div>
			        </div> <!-- /form-group-->

			        <input type="hidden" name="user_id" id="user_id" value="<?php echo $userId; ?>" /> 	
   
   				<div class="form-group">
	        	<label for="editCategoryName" class="col-sm-3 control-label">Category : </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select type="text" class="form-control" id="editCategoryName" placeholder="Product Name" name="editCategoryName" >
				      	<option value="">~~SELECT~~</option>
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
	        </div> <!-- /form-group-->	

	        




	        <div class="form-group">
	        	<label for="editBrandName" class="col-sm-3 control-label">Brand Name: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="editBrandName" name="editBrandName">
				      	/*
				      	<option value="">~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT brand_id, brand_name, brand_status,brand_slug FROM brands WHERE brand_status = 1 AND brand_category = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[3]."'>".$row[1]."</option>";
								} // while
								
								
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	






			        <!--QUANTITY NOT NEEDED IN THIS CASE BUT WILL BE NEEDED IN THE FUTURE
			        <div class="form-group">
			        	<label for="editQuantity" class="col-sm-3 control-label">Quantity: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="editQuantity" placeholder="Quantity" name="editQuantity" autocomplete="off">
						    </div>
			        </div> <!-- /form-group-->	 

			        <div class="form-group">
			        	<label for="editCost" class="col-sm-3 control-label">Wholesale Price</label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="editCost" placeholder="Cost" name="editCost" autocomplete="off" >
						    </div>
			        </div> <!-- /form-group-->
			        <div id="cost-price-error" class="col-sm-offset-4 col-sm-8"></div>	  	 	 

			        <div class="form-group">
			        	<label for="editRate" class="col-sm-3 control-label">Selling(Customer) Price: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="editRate" placeholder="Price" name="editRate" autocomplete="off"  onkeyup="numbersOnly(this)">
						    </div>
			        </div> <!-- /form-group-->	

			        <div class="form-group">
			        	<label for="editCommission" class="col-sm-3 control-label">Commission: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="editCommission" placeholder="editCommission" name="editCommission" autocomplete="off"  onkeyup="numbersOnly(this)">
						    </div>
			        </div> <!-- /form-group-->

			        <div class="form-group">
			        	<label for="editDescription" class="col-sm-3 control-label">Description: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <textarea type="text" class="form-control" id="editDescription" placeholder="Short Description" rows="3" name="editDescription" autocomplete="off" ></textarea> 
						    </div>
			        </div> <!-- /form-group-->	




			        <div id="editProductStatusSection" class="form-group">
			        	<label for="editProductStatus" class="col-sm-3 control-label">Status: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <select class="form-control" id="editProductStatus" name="editProductStatus">
						      	<option value="">~~SELECT~~</option>
						      	<option value="1">Available</option>
						      	<option value="0">Not Available</option>
						      </select>
						    </div>
			        </div> <!-- /form-group-->

			        <div class="form-group">
			        	<label for="editApprovalStatus" class="col-sm-3 control-label">Approval : </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="editApprovalStatus" placeholder="Approval Status" name="editApprovalStatus" autocomplete="off" readonly >
						    </div>
			        </div> <!-- /form-group-->	

			        	 	         	        

			        <div class="modal-footer editProductFooter">
				        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
				        
				        <button type="submit" class="btn btn-success" id="editProductBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
				      </div> <!-- /modal-footer -->				     
			        </form> <!-- /.form -->				     	
				    </div>    
				    <!-- /product info -->

				     <div role="tabpanel" class="tab-pane" id="photo">
				     	<!--<form action="php_action/editProductImage.php" method="POST" id="updateProductImageForm" class="form-horizontal" enctype="multipart/form-data">-->
				    	<form action="php_action/uploadImageFile.php" method="POST" id="updateProductImageForm" class="form-horizontal" enctype="multipart/form-data">

				    	<br />
				    	<div id="edit-productPhoto-messages"></div>

				    	<div class="form-group">
			        	<label for="ProductImage" class="col-sm-3 control-label">Product Image: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">							    				   
						      <img src="" id="getProductImage" class="thumbnail" style="width:250px; height:250px;" />
						    </div>
			        </div> <!-- /form-group-->

			        <div class="form-group" id="editProductImageInput">
			        	<label for="editProductImage" class="col-sm-3 control-label">Select image to upload: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">							    				   
						      <input type="file" style="display: inline-block;" name="editProductImage" id="editProductImage">  
						    </div>
			        </div> 	
   
				    

			      	<!--NOT EDITABLE AT THE MOMENT
			      	<div class="form-group">
			        	<label for="editProductImage" class="col-sm-3 control-label">Select Photo: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
							    // the avatar markup 
									<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
							    <div class="kv-avatar center-block">					        
							        <input type="file" class="form-control" id="editProductImage" placeholder="Product Name" name="editProductImage" class="file-loading" style="width:auto;"/>
							    </div>
						      
						    </div>
			        </div> <!-- /form-group-->	     	           	       

			        <div class="modal-footer editProductPhotoFooter">
				        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
				        
				        <button type="submit" class="btn btn-success" id="editProductImageBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
				      </div>
				      <!-- /modal-footer -->
				      </form>
				      
				      	
				      <!-- /form -->
				    </div>
				  </div>

				</div>
	      	
	      </div> <!-- /modal-body -->
	      	      
     	
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- /categories brand -->

<!-- categories brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Product</h4>
      </div>
      <div class="modal-body">

      	

      	<div class="removeProductMessages"></div>

        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer removeProductFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="removeProductBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->


<script src="custom/js/products3.js"></script>

	        <script type="text/javascript">


	        	function setbrands() {

	        		
	  
  				$('#editBrandName').html('');


    
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



    if($('#editCategoryName').val()){
 
        $('#editBrandName').append('<option value="">~~SELECT~~</option>');
    	var categoryPicked=$('#editCategoryName').val();
    	
	        	 var brandPicked=brandCategoryArray[categoryPicked];     	
			    var arrayLength = brandPicked.length;
				for (var i = 0; i < arrayLength; i++) {
					brandLowercase=brandPicked[i];
					brandUppercase=brandLowercase.charAt(0).toUpperCase() + brandLowercase.substr(1);
				    $('#editBrandName').append('<option value='+brandLowercase+'>'+brandUppercase+'</option>');
				    //Do something
				}
				$('#editBrandName').append('<option value="other">Other</option>');
         
    }else{
    	$('#editBrandName').append('<option value="other">Other</option>');
    }
}
	        		

	        	

	        	
     			$('#editProductModal').on('shown.bs.modal', function (e) {
     				brandFromInput=$('#brandHolder').val();
            	setbrands();
            	$('#editBrandName').val(brandFromInput);
      			});
				


	        	$('#editCategoryName').on('change', function(){
  				setbrands();
				});

					//change products form


	$("#changeProductsForm").unbind('submit').bind('submit', function() {

		var form = $(this);

		$(".text-danger").remove();

		var products_type = $("#products").val();

		
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();

			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					console.log(response);
					if(response.success == true) {
						$('.changeProductsMessages').html('<div class="alert alert-success">'+
	            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
	          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	    
					} else {

						$('.changeProductsMessages').html('<div class="alert alert-warning">'+
	            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            '<strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong> '+ response.messages +
	          '</div>');

						// remove the mesages
	          $(".alert-warning").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	          	
					}
				} // /success function
			}); // /ajax function

	


		return false;
	});

	        </script>

	        <script>
									function numbersOnly(input){

										var regex = /[^0-9]/gi;
										if(input.value.search(regex)>0){
											$('#cost-price-error').html('Only numbers allowed. No commas/characters. Example: 23999');

											//setTimeout("",3000);
											setTimeout("$('#cost-price-error').html('');",1500);
										}
										else{
											//setTimeout("$('#store-name-error').html('');",1500);
											
										}
										input.value=input.value.replace(regex,"");

										
									}
								</script>

								<style type="text/css">
									#manageProductTable{
										padding-bottom: 60px;
									}
								</style>


<?php require_once 'includes/footer.php'; ?>