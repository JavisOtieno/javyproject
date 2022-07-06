<?php require_once 'includes/header.php'; ?>

<?php 
$user_id = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

$facebook_link=$result['facebook_link'];
$twitter_link=$result['twitter_link'];
$instagram_link=$result['instagram_link'];
$show_founder=$result['show_founder'];
$shop_type=$result['shop_type'];
$supplier_id=$result['supplier_registered_on'];
$google_tag_code=$result['google_tag_code'];
$facebook_pixel_code=$result['facebook_pixel_code'];

$sql_supplier = "SELECT * FROM suppliers WHERE id = $supplier_id";
$query_supplier = $connect->query($sql_supplier);
$result_supplier = $query_supplier->fetch_assoc();
$supplier_name = $result_supplier['name'];



$phone=$result['phone'];
$email=$result['email'];

$display_email=$result['display_email'];
if($display_email==''){
	$display_email=$email;
}
$display_phone=$result['display_phone'];
if($display_phone==''){
	$display_phone=$phone;
}

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

				<form action="upload-profile-picture.php" method="POST" enctype="multipart/form-data">
					<legend>Change Profile Picture</legend>
					<label for="changeprofilepicture" class="col-sm-3 control-label"><!--Current -->Change Profile Picture</label>
					<div class="col-sm-offset-3">
						<?php
						if (empty($result['profile_picture']))
						{
							echo "<img style='width:60%;' src='assests/images/profile-pictures/img1.jpg'>";
						}
						else{
							echo "<img style='width:60%;' src='assests/images/profile-pictures/".$result['profile_picture']."?".mt_rand()."'>";
						}
						?>
		<input style="margin-top:10px;" type="file" name="file">
		<!--<button  type="submit" name="submit">UPLOAD</button>-->

		<button style="margin-top:10px;" type="submit" name="submit" class="btn btn-success" data-loading-text="Loading..." id="changeProfilePictureButton"> <i class="glyphicon glyphicon-ok-sign"></i> Upload </button>

	</div>
	</form>

	<form action="php_action/changeStoreName.php" method="post" class="form-horizontal" id="changeStoreNameForm">
					<fieldset>
						<legend>Change Store Name</legend>

						<div class="changeStoreNameMessages"></div>

						<div class="col-sm-offset-2" style="margin-bottom: 10px;">
						<strong>
					    Note : Changing your store name will prevent your current customers from accessing your website. <span style="color: #D72329;">Avoid changing your storename</span> unless it's completely necessary. If so, notify your customers to prevent inconvenience.
					  	</strong>		
					  	</div>	

					  	<script>
									function lettersOnly(input){
										var regex = /[^a-z0-9-]/gi;
										if(input.value.search(regex)>0){
											$('#store-name-error').html('Invalid character');

											//setTimeout("",3000);
											setTimeout("$('#store-name-error').html('');",1500);
										}
										else{
											//setTimeout("$('#store-name-error').html('');",1500);
											
										}
										input.value=input.value.replace(regex,"");

										
									}
						</script>

					  <div class="form-group">
					    <label for="storename" class="col-sm-3 control-label"><!--Current -->Store Name</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="storename" name="storename"  value="<?php echo $storename; ?>" onkeyup="lettersOnly(this)" />
					      <div id="store-name-error" class="col-sm-offset-3 col-sm-9"></div>
					    </div>
					  </div>




					 <div class="form-group">
					    <div class="col-sm-offset-3 col-sm-9">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
					      <button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeStoreNameBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					    </div>
					  </div>

					</fieldset>
				</form>


				

				<form action="php_action/changeUsername.php" method="post" class="form-horizontal" id="changeUsernameForm">
					<fieldset>
						<legend>Store Details</legend>

						<div class="changeUsernameMessages"></div>			

						<div class="form-group">
					    <label for="currentstorename" class="col-sm-3 control-label"><!--Current -->Storename (Website Name)</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="currentstorename" name="currentstorename" placeholder="Store Name" value="<?php echo $result['storename']; ?>" readonly/>
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="currentphonenumber" class="col-sm-3 control-label"><!--Current -->Phone Number</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="currentphonenumber" name="currentphonenumber" placeholder="Phone Number" value="<?php echo $result['phone']; ?>" readonly/>
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="currentemail" class="col-sm-3 control-label"><!--Current -->Email</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="currentemail" name="currentemail" placeholder="Email" value="<?php echo $result['email']; ?>" readonly/>
					    </div>
					  </div>
					  <!--
					  <div class="form-group">
					    <label for="newstorename" class="col-sm-2 control-label">New Storename (Website Name)</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="newstorename" name="newstorename" placeholder="Store Name"  />
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="newphonenumber" class="col-sm-2 control-label">New Phone Number</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="newphonenumber" name="newphonenumber" placeholder="Phone Number" />
					    </div>
					  </div>



					 <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php// echo $result['user_id'] ?>" /> 
					      <button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeUsernameBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Submit Request </button>
					    </div>
					  </div>-->
					</fieldset>
				</form>

						<form action="php_action/changeShopType.php" method="post" class="form-horizontal" id="changeShopTypeForm">
					<fieldset>
						<legend>Change Shop Type</legend>

						<div class="changeShopTypeMessages"></div>		

					  <div class="form-group">
					    <label for="shop_type" class="col-sm-3 control-label"><!--Current -->
					    	Product Categories on your website
					    </label>
					    <div class="col-sm-9">
					      <select type="text" class="form-control" id="shop_type" name="shop_type">
							  <option value="0" <?php echo $shop_type==0?'selected':'' ?> >All Products - Electronics and Fashion </option>
							  <option value="2" <?php echo $shop_type==2?'selected':'' ?>  >Electronics </option>
							  <!-- <option value="3" <?php //echo $shop_type==3?'selected':'' ?> >Fashion</option> -->

							  <?php

							  if($supplier_id){
							  	echo '<option value="4"';
							  echo $shop_type==4?'selected':''; 
							  echo '>Supplier\'s ('.$supplier_name.') Products plus My Products</option>';
							  }
							  

							  ?>
							  <option value="1" <?php echo $shop_type==1?'selected':'' ?> >My Products - Products I've added and approved</option>
							</select>
					    </div>
					  </div>



					 <div class="form-group">
					    <div class="col-sm-offset-3 col-sm-9">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
					      <button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeShopTypeBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					    </div>
					  </div>

					</fieldset>
				</form>


				<form action="php_action/changeDisplayDetails.php" method="post" class="form-horizontal" id="changeDisplayDetailsForm">
					<fieldset>
						<legend>Change phone number and email on website</legend>

						<div class="changeDisplayMessages"></div>			

					  <div class="form-group">
					    <label for="display_email" class="col-sm-3 control-label"><!--Current -->Email displayed on site</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="display_email" name="display_email"  value="<?php echo $display_email; ?>" />
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="display_phone" class="col-sm-3 control-label">Phone Number displayed on site</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="display_phone" name="display_phone"  value="<?php echo $display_phone; ?>" />
					    </div>
					  </div>



					 <div class="form-group">
					    <div class="col-sm-offset-3 col-sm-9">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
					      <button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeDisplayDetailsBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					    </div>
					  </div>

					</fieldset>
				</form>

				<form action="php_action/changePassword.php" method="post" class="form-horizontal" id="changePasswordForm">
					<fieldset>
						<legend>Change Password</legend>

						<div class="changePasswordMessages"></div>

						<div class="form-group">
					    <label for="password" class="col-sm-3 control-label">Current Password</label>
					    <div class="col-sm-9">
					      <input type="password" class="form-control" id="password" name="password" placeholder="Current Password">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="npassword" class="col-sm-3 control-label">New password</label>
					    <div class="col-sm-9">
					      <input type="password" class="form-control" id="npassword" name="npassword" placeholder="New Password">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="cpassword" class="col-sm-3 control-label">Confirm Password</label>
					    <div class="col-sm-9">
					      <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password">
					    </div>
					  </div>

					  <div class="form-group">
					    <div class="col-sm-offset-3 col-sm-9">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
					      <button type="submit" class="btn btn-success"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					      
					    </div>
					  </div>


					</fieldset>
				</form>

				

				<form action="php_action/update_social_media_and_founder.php" method="post" class="form-horizontal" id="socialMediaAndFounderForm">
					<fieldset>
						<legend>Social Media Details + Founder&CEO Page</legend>

						<div class="socialMediaAndFounderMessages"></div>

						

					  <div class="form-group">
					    <label for="facebook_page" class="col-sm-3 control-label">Facebook Link</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="facebook_page" name="facebook_page" placeholder="<?php echo ucfirst($storename) ;?> Facebook Page Link" value="<?php echo $facebook_link ;?>">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="instagram_link" class="col-sm-3 control-label">Instagram Link</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="instagram_link" name="instagram_link" placeholder="<?php echo ucfirst($storename) ;?> Instagram Profile Link" value="<?php echo $instagram_link ;?>">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="twitter_profile" class="col-sm-3 control-label">Twitter Link</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="twitter_profile" name="twitter_profile" placeholder="<?php echo ucfirst($storename) ;?> Twitter Profile Link" value="<?php echo $twitter_link ;?>">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="founder_ceo" class="col-sm-3 control-label">Founder & CEO Page</label>
					    <div class="col-sm-9">
					    	<select name="founder_ceo" class="form-control" id="founder_ceo" name="founder_ceo" value="<?php echo $show_founder ;?>">
						  <option value="1">Show</option>
						  <option value="0">Hide</option>
						</select>
					    </div>
					    
					  </div>

					  <div class="form-group">
					    <div class="col-sm-offset-3 col-sm-9">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
					      <button type="submit" class="btn btn-success"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					      
					    </div>
					  </div>


					</fieldset>
				</form>


								<form action="php_action/update_advertising_details.php" method="post" class="form-horizontal" id="advancedAdvertisingDetailsForm">
					<fieldset>
						<legend>Advanced Advertising Details</legend>

						<div class="advancedAdvertisingMessages"></div>

					  <div class="form-group">
					    <label for="facebook_pixel_code" class="col-sm-3 control-label">Facebook Pixel ID</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="facebook_pixel_code" name="facebook_pixel_code" placeholder="<?php echo ucfirst($facebook_pixel_code) ;?> Facebook Pixel ID" value="<?php echo $facebook_pixel_code ;?>">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="google_tag_code" class="col-sm-3 control-label">Google Analytics Tag ID</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="google_tag_code" name="google_tag_code" placeholder="<?php echo ucfirst($storename) ;?> Google Analytics Tag ID" value="<?php echo $google_tag_code ;?>">
					    </div>
					  </div>


					  <div class="form-group">
					    <div class="col-sm-offset-3 col-sm-9">
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
					      <button type="submit" class="btn btn-success"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					      
					    </div>
					  </div>


					</fieldset>
				</form>


				<form class="form-horizontal">
					<fieldset>
						<legend> Request .co.ke domain </legend>
						<h5>Get a .co.ke on your website instead of .av.ke </h5>
						<h5>For instance: - www.<?php echo $storename; ?>.co.ke </h5>
						<h5>Set up costs(yearly) 5,000/-</h5>
						<h5>Paybill : 247247</h5>
						<h5>Account : 545459</h5>
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

				<div class="col-sm-offset-3 col-sm-9"> 
					      <a href="logout.php"> <button type="submit" class="btn btn-danger" style="margin-left: 0px ;" > <i class="glyphicon glyphicon-log-out"></i> Log out </button> </a>
					      
					    </div>



			</div> <!-- /panel-body -->		

		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->	
</div> <!-- /row-->


<script src="custom/js/setting3.js"></script>
<?php require_once 'includes/footer.php'; ?>