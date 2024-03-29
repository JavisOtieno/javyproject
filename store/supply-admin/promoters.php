<?php require_once 'includes/header.php'; ?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Promoters</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-th-list"></i> Promoters</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>
				<!--no need for add categories
				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" data-toggle="modal" id="addCategoriesModalBtn" data-target="#addCategoriesModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add Categories </button>
				</div> --><!-- /div-action -->	


				<?php 

				$sqlpromoters="SELECT * FROM users WHERE supplier_registered_on!='$userId' ORDER BY user_id DESC";
				$promotersResult=$connect->query($sqlpromoters);
				$numberOfJavyPromoters=$promotersResult->num_rows;

				$sqlpromoters="SELECT * FROM users WHERE supplier_registered_on='$userId' ORDER BY user_id DESC";
				$promotersResult=$connect->query($sqlpromoters);
				$numberOfYourPromoters=$promotersResult->num_rows;

				//To get the average number of deal per customer
				$sqldeals="SELECT * FROM deals WHERE dealer_id='$userId'";
				$dealsResult=$connect->query($sqldeals);
				$dealsCount=$dealsResult->num_rows;

						
							?>


		 <div class="col-md-12" style="margin-top: 10px;" >
			<div class="card">
		  <div class="cardHeader" style="background-color:#F27800;">
		    <h1><?php 
		    	echo number_format($numberOfYourPromoters);
		    	 ?></h1>
		  </div>
		  <div class="cardContainer">
		    <p>Your Promoters</p>
		  </div>
		  </div>
		  </div>	

		  <!--<div class="col-md-6" style="margin-top: 10px;" >
			<div class="card">
		  <div class="cardHeader" style="background-color:#245580;">
		    <h1><?php 
		    	//echo number_format($numberOfJavyPromoters);
		    	 ?></h1>
		  </div>
		  <div class="cardContainer">
		    <p>Javy Promoters</p>
		  </div>
		  </div>
		   
		  </div>-->	

		  <div class="col-md-12" style="margin-top: 10px;" >
			<div class="card">
		  <div class="cardContainer">
		    <p>Get your promoters to sign up on <a href='http://www.<?php echo $username.$website_ke; ?>/av-admin/signup.php' target='_blank'> http://www.<?php echo $username.$website_ke; ?>/av-admin/signup.php</a></p>

		    <p style="margin-top: 10px;"> To get access to the <?php //echo number_format($numberOfJavyPromoters); ?>Javy promoters/stores, get verified. Contact us on 0716 545459</a></p>
		  </div>
		  </div>
		   
		  </div>	



				

				
				
				
				<!-- /table -->

					<div id="tableHolder">


			<table class="table" id="manageBrandTable2">
					<thead>
					<caption style="text-align: center; font-size: 20px;color: #000000;margin-top: 20px;">PROMOTERS</caption>
						<tr>							
							<th>Promoter Name</th>
							<th>Website</th>
							<th>Website Visits</th>
							<th>Orders</th>
							<th>Succesful Orders</th>
							<th>Status</th>
							<th style="width:15%;">Options</th>
						</tr>
					</thead>
					<tbody>
						<?php 

						if($promotersResult->num_rows>0){
							while($row=$promotersResult->fetch_assoc()){
								echo "<tr>";
								echo '<td>'.ucfirst($row['firstname']).' '.ucfirst($row['lastname']).'</td>';
								echo '<td>www.'.$row['storename'].'.av.ke</td>';
								echo '<td>'.$row['web_visits'].'</td>';
								

								$supplierId=$row['id'];
								$store_id=$row['user_id'];

								$sqldeals = "SELECT * FROM deals WHERE dealer_id='$store_id'";
								$resultdeals = $connect->query($sqldeals);
								$totaldeals=$resultdeals->num_rows;

								echo '<td>'.$totaldeals.'</td>';

								$sqlsuccesfuldeals = "SELECT * FROM deals WHERE dealer_id='$store_id' AND status=1";
								$resultsuccesfuldeals = $connect->query($sqlsuccesfuldeals);
								$totalsuccesfuldeals=$resultsuccesfuldeals->num_rows;

								echo '<td>'.$totalsuccesfuldeals.'</td>';



								//filling the table with useless stuff. This does not mean anything. Why would I check the id to validate as active. Everything is green :-) humour :-) in code :-)
									if($totaldeals>0){
							 		// activate member
							 		$active = "<label class='label label-success'>Active</label>";
							 	} else {
							 		// deactivate member
							 		$active = "<label class='label label-warning'>Inactive</label>";
							 	}


								echo '<td>'.$active.'</td>';

								$promoter_id=$row['user_id'];
								$button = '<!-- Single button -->

								<div class="btn-group">

								<a href="view-promoter.php?id='.$promoter_id.'" id="editOrderModalBtn"><button type="button" class="btn btn-default " 
								  aria-haspopup="true" > <i class="glyphicon glyphicon-eye-open"></i> View </button></a>
								  <!--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    Action <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu">
								    <li><a href="view-promoter.php?id='.$promoter_id.'" id="editOrderModalBtn"> <i class="glyphicon glyphicon-eye-open"></i> View</a></li>
								    
								    <!--<li><a type="button" data-toggle="modal" id="paymentOrderModalBtn" data-target="#paymentOrderModal" onclick="paymentOrder('.$deal_id.')"> <i class="glyphicon glyphicon-save"></i> Payment</a></li>

								    <li><a type="button" onclick="printOrder('.$deal_id.')"> <i class="glyphicon glyphicon-print"></i> Print </a></li>
								    
								    <li><a type="button" data-toggle="modal" data-target="#removeOrderModal" id="removeOrderModalBtn" onclick="removeOrder('.$deal_id.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>  -->     
								  </ul>
								</div>';

								echo '<td>'.$button.'</td>';



								echo "</tr>";
							}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No promoters so far</td></tr>";
						}
						
						$connect->close();
						?>
					</tbody>
			</table>
			</div>

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->


<!-- add categories -->
<div class="modal fade" id="addCategoriesModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

    	<form class="form-horizontal" id="submitCategoriesForm" action="php_action/createCategories.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Categories</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="add-categories-messages"></div>

	        <div class="form-group">
	        	<label for="categoriesName" class="col-sm-4 control-label">Categories Name: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" id="categoriesName" placeholder="Categories Name" name="categoriesName" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	         	        
	        <div class="form-group">
	        	<label for="categoriesStatus" class="col-sm-4 control-label">Status: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <select class="form-control" id="categoriesStatus" name="categoriesStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Available</option>
				      	<option value="2">Not Available</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	         	        
	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
	        
	        <button type="submit" class="btn btn-primary" id="createCategoriesBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
	      </div> <!-- /modal-footer -->	      
     	</form> <!-- /.form -->	     
    </div> <!-- /modal-content -->    
  </div> <!-- /modal-dailog -->
</div> 
<!-- /add categories -->


<!-- edit categories brand -->
<div class="modal fade" id="editCategoriesModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="editCategoriesForm" action="php_action/editCategories.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Brand</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="edit-categories-messages"></div>

	      	<div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
					</div>

		      <div class="edit-categories-result">
		      	<div class="form-group">
		        	<label for="editCategoriesName" class="col-sm-4 control-label">Categories Name: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="editCategoriesName" placeholder="Categories Name" name="editCategoriesName" autocomplete="off">
					    </div>
		        </div> <!-- /form-group-->	         	        
		        <div class="form-group">
		        	<label for="editCategoriesStatus" class="col-sm-4 control-label">Status: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-7">
					      <select class="form-control" id="editCategoriesStatus" name="editCategoriesStatus">
					      	<option value="">~~SELECT~~</option>
					      	<option value="1">Available</option>
					      	<option value="2">Not Available</option>
					      </select>
					    </div>
		        </div> <!-- /form-group-->	 
		      </div>         	        
		      <!-- /edit brand result -->

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer editCategoriesFooter">
	        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
	        
	        <button type="submit" class="btn btn-success" id="editCategoriesBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>
	     <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- /categories brand -->

<!-- categories brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeCategoriesModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Brand</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer removeCategoriesFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="removeCategoriesBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->


<script src="custom/js/promoters.js"></script>

<?php require_once 'includes/footer.php'; ?>