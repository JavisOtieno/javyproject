<?php require_once 'includes/header.php'; ?>

<?php 
$user_id = $_SESSION['supplierId'];
$sql = "SELECT * FROM suppliers WHERE id = {$user_id}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

$google_tag_code=$result['google_tag_code'];
$facebook_pixel_code=$result['facebook_pixel_code'];

$connect->close();
?>

<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Settings</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-wrench"></i> Settings</div>
			</div> <!-- /panel-heading -->

			<div class="panel-body">	

				<form action="php_action/changeUsername.php" method="post" class="form-horizontal" id="changeUsernameForm">
					<fieldset>
						<legend>Supplier Details</legend>

						<div class="changeNameMessages"></div>			

						<div class="form-group">
					    <label for="name" class="col-sm-2 control-label">Name</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="name" name="name" placeholder="name" value="<?php echo $result['name']; ?>" readonly/>
					    </div>
					  </div>

					  <div class="changeUsernameMessages"></div>			

						<div class="form-group">
					    <label for="username" class="col-sm-2 control-label">Username</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $result['username']; ?>" readonly/>
					    </div>
					  </div>

					 <!-- <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php //echo $result['user_id'] ?>" /> 
					      <button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeUsernameBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					    </div>
					  </div>-->
					</fieldset>
				</form>

				<form action="php_action/changePassword.php" method="post" class="form-horizontal" id="changePasswordForm">
					<fieldset>
						<legend>Change Password</legend>

						<div class="changePasswordMessages"></div>

						<div class="form-group">
					    <label for="password" class="col-sm-2 control-label">Current Password</label>
					    <div class="col-sm-10">
					      <input type="password" class="form-control" id="password" name="password" placeholder="Current Password">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="npassword" class="col-sm-2 control-label">New password</label>
					    <div class="col-sm-10">
					      <input type="password" class="form-control" id="npassword" name="npassword" placeholder="New Password">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="cpassword" class="col-sm-2 control-label">Confirm Password</label>
					    <div class="col-sm-10">
					      <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password">
					    </div>
					  </div>

					  <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['id'] ?>" /> 
					      <button type="submit" class="btn btn-primary"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					      
					    </div>
					  </div>


					</fieldset>
				</form>


				<form action="php_action/changeProducts.php" method="post" class="form-horizontal" id="changeProductsForm">
					<fieldset>
						<legend>Select Products on Website</legend>

						<div class="changeProductsMessages"></div>			

						<div class="form-group">
					    <label for="products" class="col-sm-2 control-label">Products on Website</label>
					    <div class="col-sm-10">
					     
					      <select class="form-control" id="products" name="products" placeholder="products" value="<?php echo $result['products']; ?>" >
					      	<option value="0" <?php echo $products_type==0?'selected':'' ?> > Your Products</option>
							  <option value="1" <?php echo $products_type==1?'selected':'' ?>  > Javy Products & Your Products </option>
							</select>
					      	
					     
					    </div>
					  </div>

					   <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['id'] ?>" /> 
					      <button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeDisplayProductsBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					    </div>
					  </div>		

					</fieldset>
				</form>


												<form action="php_action/update_advertising_details.php" method="post" class="form-horizontal" id="advancedAdvertisingDetailsForm">
					<fieldset>
						<legend>Advanced Advertising Details</legend>

						<div class="advancedAdvertisingMessages"></div>

					  <div class="form-group">
					    <label for="facebook_pixel_code" class="col-sm-2 control-label">Facebook Pixel ID</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="facebook_pixel_code" name="facebook_pixel_code" placeholder="<?php echo ucfirst($facebook_pixel_code) ;?> Facebook Pixel ID" value="<?php echo $facebook_pixel_code ;?>">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="google_tag_code" class="col-sm-2 control-label">Google Analytics Tag ID</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="google_tag_code" name="google_tag_code" placeholder="<?php echo ucfirst($storename) ;?> Google Analytics Tag ID" value="<?php echo $google_tag_code ;?>">
					    </div>
					  </div>


					  <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['id'] ?>" /> 
					      <button type="submit" class="btn btn-primary"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					      
					    </div>
					  </div>


					</fieldset>
				</form>

				<form action="php_action/changeDisplayDetails.php" method="post" class="form-horizontal" id="cokeForm">
					<fieldset>
						<legend> Request .co.ke domain </legend>
						<h5>Get a .co.ke on your website instead of .av.ke </h5>
						<h5>For instance: - www.<?php echo $username; ?>.co.ke </h5>
						<h5>Set up costs(yearly) 5,000/-</h5>
						<h5>Contact us on <strong>0716 545459</strong> for setup</h5>

					</fieldset>
				</form>

				<form class="form-horizontal" >
					<fieldset>
						<legend> Secure your site with an SSL Certificate </legend>
						<h5>Set up costs(one time payment) 100/-</h5>
						<h5>Paybill : 247247</h5>
						<h5>Account : 545459</h5>
						<h5>Contact us on <strong>0716 545459</strong> after making payment</h5>

					</fieldset>
				</form>

				<legend>Log Out</legend>

				<div class="col-sm-offset-2 col-sm-10"> 
					      <a href="logout.php"> <button type="submit" class="btn btn-danger" style="margin-left: 0px ;" > <i class="glyphicon glyphicon-log-out"></i> Log out </button> </a>
					      
					    </div>



			</div> <!-- /panel-body -->		

		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->	
</div> <!-- /row-->


<script src="custom/js/setting1.js"></script>
<?php require_once 'includes/footer.php'; ?>