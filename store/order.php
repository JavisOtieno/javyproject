<?php
session_start();

   if(!isset($_SESSION['customerId'])) {
  header('location: login.php');    
}else{
  $customerId=$_SESSION['customerId'];
}

   if(isset($_GET['orderId'])) {
	$orderId=$_GET['orderId'];		
      }

?>
<?php include 'header.php';

$sqlorder="SELECT * FROM deals WHERE id=".$orderId;
$query_run_order=mysqli_query($db_link,$sqlorder);
  if($row=mysqli_fetch_assoc($query_run_order)){
  $customer_name=$row['name'];
  $customer_phone=$row['phone'];
  $customer_email=$row['email'];
  $customer_delivery=$row['delivery_details'];
  $product_name=$row['product_name'];
  $product_price=$row['product_price'];
  $status=$row['status'];
    if($row['status']==2){
      $status ="cancelled";
    }else if($row['status']==1){
      $status ="complete";
    }else{
      $status ="processing";
    }
  }

$sqlcustomerpassword="SELECT * FROM customers WHERE id=".$customerId;
$query_run_customer_password=mysqli_query($db_link,$sqlcustomerpassword);
  if($row=mysqli_fetch_assoc($query_run_customer_password)){
  $customer_password=$row['password'];
  }

?>


<?php
  $sql="SELECT * FROM customers WHERE id='$customerId'";
   $result=$connect->query($sql);

   $count=0;

   while($row=mysqli_fetch_assoc($result)){
    $customer_name=$row['name'];
    $customer_email=$row['email'];
    $customer_phone=$row['phone'];
    $customer_delivery=$row['deliverydetails'];

  }

?>
	<!-- //header --> 	
	<!-- sign up-page -->
	<div class="login-page">
		<div class="container"> 

       <div style="margin-bottom: 30px;">
      <a href="orders.php"><button type='button' class='btn btn-primary'>Orders</button></a>
      <!--<a href="messages.php"><button type='button' class='btn btn-primary'>Messages</button></a>-->
      <a href="account-details.php"><button type='button' class='btn btn-primary'>Account Details</button></a>
      <a href="logout.php"><button type='button' class='btn btn-primary'>Log out</button></a>
    </div>
       <?php
      if($customer_password==''){
        echo "<a href='set-password.php'><h4 style='text-align:center;margin-bottom:30px;'><span style='margin-right:30px;'>Finish setting up your account by setting your password</span><button type='button' class='btn btn-primary'>Set Password</button></h4></a>";
      }
      
      ?>

			<h3 class="w3ls-title w3ls-title1">Order</h3> 

      <div id="login-messages"></div> 
      <div class="login-body">
        <form method="post" id='loginForm'>
          <h4 style="margin-bottom: 15px;"><?php echo $product_name." @ KSh. ".number_format($product_price); ?></h4>
          <div><div style="display: inline-block;width: 30%;">Name:</div> <input style="width: 65%;" type="text" class="user" id="name" name="name" placeholder="Enter your Name" required="" readonly value="<?php echo $customer_name; ?>"></div>
           <div><div style="display: inline-block;width: 30%;">Phone:</div> <input type="text" style="width: 65%;" class="user" id="phone" name="phone" placeholder="Enter your phone number" readonly required="" value="<?php echo $customer_phone; ?>"></div>
           <div><div style="display: inline-block;width: 30%;">Email:</div> <input style="width: 65%;" type="text" class="user" id="email" name="email" placeholder="Enter your email" readonly required="" value="<?php echo $customer_email; ?>"></div>
           <div><div style="display: inline-block;width: 30%;">Delivery Details:</div> <input style="width: 65%;" type="text" class="user" id="address" name="address" placeholder="Enter your delivery details (Location details)" readonly required="" value="<?php echo $customer_delivery; ?>"></div>
           <div><div style="display: inline-block;width: 30%;">Status:</div> <input style="width: 65%;" type="text" class="user" id="status" name="status" placeholder="Status" readonly required="" value="<?php echo $status; ?>"></div>
        

           <!--
          
          <div class="forgot-grid">
            <label class="checkbox"><input type="checkbox" name="remember" value="1"><i></i>Remember me</label>
            <div class="forgot">
              <a href="#">Forgot Password?</a>
            </div>-->
            <div class="clearfix"> </div>
          </div>
        </form>
                   <?php if ($status=="processing") {
           echo '<td><a href="cancel-order.php?orderId='.$orderId.'"><button type="button" class="btn btn-primary btn-lg" style="background-color: #F44336;margin-top:15px;"">Cancel Order</button></a></td>';
        }
        ?>
      </div> 
		
		</div>
	</div>
	<!-- //sign up-page --> 
	<?php include 'footer.php'; ?>