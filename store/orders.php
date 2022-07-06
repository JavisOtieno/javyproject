<?php
session_start();

   if(!isset($_SESSION['customerId'])) {
	header('location: login.php');		
}else{
	$customerId=$_SESSION['customerId'];
}


?>
<?php include 'header.php';

$sqlnumberexists="SELECT * FROM customers WHERE id=".$customerId;

$query_run_number_exists=mysqli_query($db_link,$sqlnumberexists);

  if($row=mysqli_fetch_assoc($query_run_number_exists)){
  $customer_password=$row['password'];
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
			<h3 class="w3ls-title w3ls-title1">Orders</h3> 

			<table class="table" >
        <!--
          // Removes overflow but text overlaps
          style="table-layout:fixed;width:100%;"

        -->
    <thead>
      <tr>
        <td style="width: 15%;"><strong>Product Name</strong></td>
        <td style="width: 10%;"><strong>Price</strong></td>
        <td><strong>Payment</strong></td>
        <td><strong>Status</strong></td>
        <td><strong>View Order</strong></td>
        <td><strong>Cancel Order</strong></td>
      </tr>
    </thead>
    <tbody>



<?php

   $sql="SELECT * FROM deals WHERE customer_id='$customerId'";
   $result=$connect->query($sql);

   $count=0;

   while($row=mysqli_fetch_assoc($result)){

   	/*Label determined by status and not count
    if ($count==0){
   		$label="success";
   	}elseif ($count==1) {
   		$label="danger";
   	}elseif ($count==2) {
   		$label="info";
   	}elseif ($count==3) {
   		$label="warning";
   	}elseif ($count==4) {
   		$label="active";
   	}*/


    if($row['status']==2){
      $status ="cancelled";
      $label="danger";
    }else if($row['status']==1){
      $status ="complete";
      $label="success";
    }else{
      $status ="processing";
      $label="warning";
    }

    //work on introducing payment on the database

     if($row['payment']==0){
      $payment_status ='<a href="make-payment.php?orderId='.$row['id'].'"><button type="button" class="btn btn-primary">Make Payment</button></a>';
    }else if($row['payment']==1){
      $payment_status ="payment complete";
    }
      //$payment_status ='<a href="make-payment.php?orderId='.$row['id'].'"><button>Make Payment</button></a>';
      //$payment_status="yet to pay";
    // 


   	echo '<tr class="'.$label.'">
        <td style="width:25%">'.$row['product_name'].'</td>
        <td style="width:10%">'.number_format($row['product_price']).'</td>
        <td>'.$payment_status.'</td>
        <td>'.$status.'</td>';
        /*
        if ($status=="processing") {
           echo '<td><button>Edit Order</button></td>';
        }else{
          echo '<td><button>View Order</button></td>';
        }*/
        echo '<td><a href="order.php?orderId='.$row['id'].'"><button type="button" class="btn btn-primary">View Order</button></a></td>';
        if ($status=="processing") {
           echo '<td><a href="cancel-order.php?orderId='.$row['id'].'"><button type="button" class="btn btn-danger">Cancel Order</button></a></td>';
        }else{
          echo '<td></td>';
        }
      echo '</tr>';


      $count++;

      if($count==5){
      	$count=0;
      }


   }

   if(mysqli_num_rows($result)==0){
   	echo "<tr class='danger'><td colspan=5>You have not made any orders yet.<td/><tr/>";
   }


   ?>

    </tbody>
  </table>	
		
		</div>
	</div>
	<!-- //sign up-page --> 
	<?php include 'footer.php'; ?>