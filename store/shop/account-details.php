<?php
session_start();

   if(!isset($_SESSION['customerId'])) {
	header('location: login.php');		
}else{
	$customerId=$_SESSION['customerId'];

   }



?>
<?php include 'header.php';

  if(isset($_GET['action'])){
    if($_GET['action']=='edit'){
      $readonly='';



    }elseif( $_GET['action']=='submit' ){
      $readonly='readonly';

        if($_POST){

          $new_name=$_POST['name'];
          $new_phone=$_POST['phone'];
          $new_email=$_POST['email'];
          $new_address=$_POST['address'];

          $sqlupdatecustomer="UPDATE customers SET name='$new_name',phone='$new_phone',email='$new_email',deliverydetails='$new_address' WHERE id=".$customerId;



  if($query_run_update_customer=mysqli_query($db_link,$sqlupdatecustomer)){

    $message='<div class="alert alert-success">
  <strong>Success!</strong> Details updated</a>.
</div>';
  }else{
    $message='<div class="alert alert-danger">
  <strong>Sorry!</strong> Details not updated</a>.
</div>';
  }


        }
      

    }else{
      $readonly='readonly';
    }
    
  }


$sqlnumberexists="SELECT * FROM customers WHERE id=".$customerId;

$query_run_number_exists=mysqli_query($db_link,$sqlnumberexists);

  if($row=mysqli_fetch_assoc($query_run_number_exists)){
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
      <a href="messages.php"><button type='button' class='btn btn-primary'>Messages</button></a>
      <a href="account-details.php"><button type='button' class='btn btn-primary'>Account Details</button></a>
      <a href="logout.php"><button type='button' class='btn btn-primary'>Log out</button></a>
    </div>
       <?php
      if($customer_password==''){
        echo "<a href='set-password.php'><h4 style='text-align:center;margin-bottom:30px;'><span style='margin-right:30px;'>Finish setting up your account by setting your password</span><button type='button' class='btn btn-primary'>Set Password</button></h4></a>";
      }
      
      ?>

			<h3 class="w3ls-title w3ls-title1">Account Details</h3> 

      <div id="login-messages"><?php echo $message; ?></div> 
      <div class="login-body">
        <form action="account-details.php?action=submit" method="post" id='loginForm'>
          <div><div style="display: inline-block;">Name:</div> <input style="width: 80%;" type="text" class="user" id="name" name="name" placeholder="Enter your Name" required=""  <?php echo $readonly; ?> value="<?php echo $customer_name; ?>"></div>
           <div><div style="display: inline-block;">Phone:</div> <input type="text" style="width: 80%;" class="user" id="phone" name="phone" placeholder="Enter your phone number" required=""  <?php echo $readonly ;?> value="<?php echo $customer_phone; ?>"></div>
           <div><div style="display: inline-block;">Email:</div> <input style="width: 80%;" type="text" class="user" id="email"  <?php echo $readonly ;?> name="email" placeholder="Enter your email" required="" value="<?php echo $customer_email; ?>"></div>
           <div><div style="display: inline-block;">Delivery Details:</div> <input style="width: 66%;" type="text" class="user" id="address" name="address" placeholder="Enter your delivery details (Location details)" <?php echo $readonly ;?> required="" value="<?php echo $customer_delivery; ?>"></div>

      <?php

     if($_GET['action']!='edit'){
      echo "<a href='account-details.php?action=edit'><button type='button' class='btn btn-primary'>Edit Details</button></a>";
    
    }else if($_GET['action']=='edit'){
      echo "<button type='submit' class='btn btn-primary'>Save Details</button></a>";
    }
    

      ?>
        

           <!--
          <input type="submit" value="Login">
          <div class="forgot-grid">
            <label class="checkbox"><input type="checkbox" name="remember" value="1"><i></i>Remember me</label>
            <div class="forgot">
              <a href="#">Forgot Password?</a>
            </div>-->
            <div class="clearfix"> </div>
          </div>
        </form>
      </div> 
		
		</div>
	</div>
	<!-- //sign up-page --> 
	<?php include 'footer.php'; ?>

  <script type="text/javascript">
    setInterval(function(){
      var link = document.getElementById('login-messages');
      $(link).hide()
  },3000);

  </script>