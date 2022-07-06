<?php
session_start();

   if(!isset($_SESSION['customerId'])) {
	header('location: login.php');		
}else{
	$customerId=$_SESSION['customerId'];
}

 include 'header.php';


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
      <a href="messages.php"><button type='button' class='btn btn-primary'>Messages</button></a>
      <a href="account-details.php"><button type='button' class='btn btn-primary'>Account Details</button></a>
      <a href="logout.php"><button type='button' class='btn btn-primary'>Log out</button></a>
    </div>
       <?php
      if($customer_password==''){
        echo "<a href='set-password.php'><h4 style='text-align:center;margin-bottom:30px;'><span style='margin-right:30px;'>Finish setting up your account by setting your password</span><button type='button' class='btn btn-primary'>Set Password</button></h4></a>";
      }
      
      ?>
			<h3 class="w3ls-title w3ls-title1">Messages</h3> 

			<table class="table">
    <thead>
      <tr>
        <td style="width: 30%;"><strong>Message</strong></td>
        <td style="width: 20%;"><strong>Date</strong></td>
        <!--<td><strong>Delivery Details</strong></td>-->
        <td><strong>Status</strong></td>
      </tr>
    </thead>
    <tbody>



<?php

   $sql="SELECT * FROM product_messages WHERE customer_id='$customerId'";
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

   	echo '<tr class="'.$label.'">
        <td style="width:30%">'.$row['message'].'</td>
        <td style="width:20%">'.date('d/m/Y \a\t h:iA',$row["date"]).'</td>
        <td>'.$status.'</td>
      </tr>';


      $count++;

      if($count==5){
      	$count=0;
      }


   }

   if(mysqli_num_rows($result)==0){
   	echo "<tr class='danger'><td colspan=2>You have not sent any yet.<td/><tr/>";
   }


   ?>

    </tbody>
  </table>	
		
		</div>
	</div>
	<!-- //sign up-page --> 
	<?php include 'footer.php'; ?>