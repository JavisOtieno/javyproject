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



$req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
$response_json = file_get_contents($req_url);

// Continuing if we got a result
if(false !== $response_json) {

    // Try/catch for json_decode operation
    try {

    // Decoding
    $response_object = json_decode($response_json);

    // YOUR APPLICATION CODE HERE, e.g.
    $base_price = 1; // Your price in USD
    $KES_price = round(($base_price * $response_object->rates->KES), 2);

    //echo $KES_price;

    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }
}

$price_plus_charges=$product_price*1.06;
$price_in_usd_plus_charges=round(($price_plus_charges/$KES_price),0);



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

      

			<h3 class="w3ls-title w3ls-title1">Make Payment</h3> 

      <h4 class="w3ls-title w3ls-title1">Note: Contact <?php echo $phone_number; ?> to confirm availability before you make your payment</h4> <br/><br/>

      <h4 class="w3ls-title w3ls-title1">M-Pesa Paybill : 522522</h4> 
      <h4 class="w3ls-title w3ls-title1">Account Number : 1172923485</h4> 

      <!--<div class="login-body">-->
        <br/><br/>
                <div class="col-md-12">
          <h4 class="w3ls-title w3ls-title1">Pay via Paypal or Card <?php echo $price_in_usd_plus_charges ?> USD <br>Note: This will cost you an extra 6% in transaction fees</h4><br/>


  <!--make paypal payment-->      
    <div id="smart-button-container" width="80%;">
      <div style="text-align: center;">
        <div id="paypal-button-container"></div>
      </div>
    </div>

  </div>

                                
                
             
    <!--</div>-->

        
      </div> 
		
		</div>
	</div>



      <script src="https://www.paypal.com/sdk/js?client-id=AVHjY4QrBuP6mb8K2rPh0O-BG0UgCzoWEYW_75Ry9McIugCoPbZFE_1PxS4GAAr1DnpuVy-pjp7lrKWv&locale=en_KE&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
  <script>


    function initPayPalButton() {
      paypal.Buttons({
        locale: 'en_KE',
        style: {
          shape: 'rect',
          color: 'gold',
          layout: 'vertical',
          label: 'paypal',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"amount":{"currency_code":"USD","value":<?php echo $price_in_usd_plus_charges;?>}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
            alert('Transaction completed by ' + details.payer.name.given_name + '!');
            window.location.replace("/confirm-payment.php?id=<?php echo $orderId;?>");

          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
  </script>
	<!-- //sign up-page --> 
	<?php include 'footer.php'; ?>


