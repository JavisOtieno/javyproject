<?php require_once 'includes/header.php'; ?>

<?php 

$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


if (strpos($actual_link, 'localhost') !== false){


$mysqli_host='localhost';
$mysqli_username='root';
$mysqli_password='';
$mysqli_database='stock2';

}
else{

$mysqli_host='sql286.your-server.de';
$mysqli_username='javy2021';
$mysqli_password='@Ja20vy20';
$mysqli_database='javy2021';


}

date_default_timezone_set("Africa/Nairobi");

          if(isset($_GET['type'])){
							$type=$_GET['type'];	
			}
		else{
					$type="web_visits";
			}










if($db_link=@mysqli_connect($mysqli_host,$mysqli_username,$mysqli_password,$mysqli_database))
{
	
}
$connect = new mysqli($mysqli_host,$mysqli_username, $mysqli_password, $mysqli_database);

if($connect->connect_error){
	echo 'Connection failed:'.$connect->connect_error;
}else{
	//echo "succesfully connected.";
}


//get user storename
$query_user="SELECT * FROM users WHERE user_id='$userId'";
$query_run_user=mysqli_query($db_link,$query_user);
while($row=mysqli_fetch_assoc($query_run_user)){
	$storename=$row['storename'];
}


//require 'connect.inc.php';

$query='SELECT * FROM users WHERE user_id!=2';

$query_run=mysqli_query($db_link,$query);

$number_of_users=mysqli_num_rows($query_run);



// echo '<div>
// <div style="width:5%;display:inline-block;" ><strong>ID</strong></div>
// <div style="width:15%;display:inline-block;"><strong>StoreName</strong></div>
// <div style="width:10%;display:inline-block;"><strong>Promoter Name</strong></div>
// <div style="width:10%;display:inline-block;"><strong>Promoter Phone</strong></div>
// <div style="width:5%;display:inline-block;"><strong>Web Visits</strong></div>
// <div style="width:10%;display:inline-block;"><strong>View/Edit</strong></div>
// <div style="width:5%;display:inline-block;"><strong>Total Earnings</strong></div>
// <div style="width:5%;display:inline-block;"><strong>Earnings Available</strong></div>
// <div style="width:5%;display:inline-block;"><strong>Login</strong></div>
// <div style="width:5%;display:inline-block;"><strong>Withdraw</strong></div>
// </div>';




$promoters_array=array();

while($row=mysqli_fetch_assoc($query_run)){

	$userId=$row['user_id'];

	$sqlearnings= "SELECT product_price,product_profit FROM deals WHERE status=1 AND dealer_id=$userId";
$query_run2=mysqli_query($db_link,$sqlearnings);
$totalRevenue=0;
$totalProfit=0;
while($row2=mysqli_fetch_assoc($query_run2)){
	$totalRevenue += $row2['product_price'];
	$totalProfit += $row2['product_profit'];
}


$promoters_array += [$row['storename']=>$totalRevenue];


// echo '<div style="margin:20px">
// <div style="width:5%;display:inline-block;" >'.$row['user_id'].'</div>
// <div style="width:15%;display:inline-block;">'.$row['storename'].'</div>
// <div style="width:10%;display:inline-block;">'.$row['firstname'].' '.$row['lastname'].'</div>
// <div style="width:10%;display:inline-block;">'.$row['phone'].'</div>
// <div style="width:5%;display:inline-block;">'.$row['web_visits'].'</div>
// <div style="width:10%;display:inline-block;"><a href="edit-promoter.php?id='.$row['user_id'].'"><button>view/edit</button></a></div>
// <div style="width:5%;display:inline-block;">'.$totalEarningsToDate.'</div>
// <div style="width:5%;display:inline-block;">'.$totalEarningsAvailable.'</div>
// <div style="width:5%;display:inline-block;"><a href="http://www.javy.co.ke/bypass.php?id='.$row['user_id'].'" target="_blank"><button>Login</button></a></div>
// <div style="width:5%;display:inline-block;"><a href="add-withdrawal.php?id='.$row['user_id'].'"><button>Withdraw</button></a></div>

// </div>';

}

arsort($promoters_array);

// echo '<div style="margin:20px">
// <div style="width:5%;display:inline-block;" >'.$row['user_id'].'</div>
// <div style="width:15%;display:inline-block;">'.$row['storename'].'</div>
// <div style="width:10%;display:inline-block;">'.$row['firstname'].' '.$row['lastname'].'</div>
// <div style="width:10%;display:inline-block;">'.$row['phone'].'</div>
// <div style="width:5%;display:inline-block;">'.$row['web_visits'].'</div>
// <div style="width:10%;display:inline-block;"><a href="edit-promoter.php?id='.$row['user_id'].'"><button>view/edit</button></a></div>
// <div style="width:5%;display:inline-block;">'.$totalEarningsToDate.'</div>
// <div style="width:5%;display:inline-block;">'.$totalEarningsAvailable.'</div>
// <div style="width:5%;display:inline-block;"><a href="http://www.javy.co.ke/bypass.php?id='.$row['user_id'].'" target="_blank"><button>Login</button></a></div>
// <div style="width:5%;display:inline-block;"><a href="add-withdrawal.php?id='.$row['user_id'].'"><button>Withdraw</button></a></div>

// </div>';

$count_position=0;

foreach ($promoters_array as $key => $value) {
	

if($key==$storename){
	$user_sales_position=$count_position;
}
$count_position++;
}









//display on web visits


$query='SELECT * FROM users WHERE user_id!=2';

$query_run4=mysqli_query($db_link,$query);



$promoters_web_array=array();

while($row=mysqli_fetch_assoc($query_run4)){

	$userId=$row['user_id'];

	$sqlearnings= "SELECT web_visits FROM users WHERE user_id='$userId'";
$query_run2=mysqli_query($db_link,$sqlearnings);
while($row2=mysqli_fetch_assoc($query_run2)){
	$web_visits=$row2['web_visits'];
}


$promoters_web_array += [$row['storename']=>$web_visits];

}


arsort($promoters_web_array);



$count_position=0;
foreach ($promoters_web_array as $key => $value) {
	

if($key==$storename){
	$user_web_position=$count_position;
}
$count_position++;

}



?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Rank</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i>
					<?php 
					if($type=="sales"){
					echo "Ranking as per sales";
				}else{
					echo "Ranking as per website visits";
				}
				?></div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<div class="col-md-6" style="margin-top: 10px;">
			<div class="card">
		  <div class="cardHeader" style="background-color:#F27800;">
		    <h1><?php 
		    	echo number_format($user_web_position+1);
		    	 ?></h1>
		  </div>
		  <div class="cardContainer">
		    <p>Position as per Website Visits</p>
		  </div>
		  </div>
		  <div style="margin-top:20px;padding-bottom:20px;" >
					<a href="rank.php"><button style="width: 100%;" class="btn btn-default button1"> <i class="glyphicon glyphicon-cart"></i> View Position as per website visits </button></a>
				</div> <!-- /div-action -->	
		  </div>

		  <div class="col-md-6" style="margin-top: 10px;">
		  <div class="card" style="margin-bottom: 20px;">
		  <div class="cardHeader" id="EarningsToDateCardHeader" >
		    <h1><?php 
		    	echo number_format($user_sales_position+1);
		    	 ?></h1>
		  </div>
		  <div class="cardContainer">
		    <p>Position as per Sales</p>
		  </div>
		  </div>

		  <div style="margin-top:20px;padding-bottom:20px;" >
					<a href="rank.php?type=sales"><button style="width: 100%;" class="btn btn-default button1"> <i class="glyphicon glyphicon-cart"></i> View position as per sales </button></a>
				</div> <!-- /div-action -->	

		  </div>

		

			

				<div class="remove-messages"></div>


			<style type="text/css">

				@media 
only screen and (max-width: 414px),(max-device-width: 414px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}
	
	td:before { 
		/* Now like a table header */
		
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	/*
	Label the data
	*/
	td:nth-of-type(1):before { content: "Date and Time: "; }
	td:nth-of-type(2):before { content: "Customer Name: "; }
	td:nth-of-type(3):before { content: "Message: "; }
	td:nth-of-type(4):before { content: "Status: "; }
	
}
			</style>				
			
			<div id="tableHolder">


			<table class="table" id="manageBrandTable2">
					<thead>
					<caption style="text-align: center; font-size: 20px;color: #000000;"><?php 
					if($type=="sales"){
					echo "Ranking as per sales";
				}else{
					echo "Ranking as per website visits";
				}
				?></caption>
						<tr>							
							<th>Position</th>
							<th>Store Name</th>
							<th>Website</th>
							<th style="width:15%;">
								<?php if($type=="sales"){echo "Sales";}else{ echo "Web Visits";}?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php

						

						if($type=="sales"){

$keys=array_keys($promoters_array);

for($count=0;$count<5;$count++){
$position=$count+1;
echo "<tr>";
								echo '<td>'.$position.'</td>';
								echo '<td>'.$keys[$count].'</td>';
								echo '<td>'.'www.'.$keys[$count].'.av.ke.</td>';
								echo '<td>'.number_format($promoters_array[$keys[$count]]).'</td>';
echo "</tr>";
}

echo "<tr>";
								echo '<td>---</td>';
								echo '<td>---</td>';
								echo '<td>---</td>';
								echo '<td>---</td>';
echo "</tr>";

$x=$user_sales_position;
for($count=($x-2);$count<=($x+2);$count++){
	

	$position=$count+1;

	//prevent position being 0 or negative
	if($position>4&&$position<$number_of_users){

		if($count==$user_sales_position){
			echo "<tr bgcolor='#D9EDF7'>";
		}else{
			echo "<tr>";
		}

								echo '<td>'.$position.'</td>';
								echo '<td>'.$keys[$count].'</td>';
								echo '<td>'.'www.'.$keys[$count].'.av.ke.</td>';
								echo '<td>'.number_format($promoters_array[$keys[$count]]).'</td>';
echo "</tr>";
}

}

							

						}else{

							$keys=array_keys($promoters_web_array);

						for($count=0;$count<5;$count++){
	$position=$count+1;

echo "<tr>";
								echo '<td>'.$position.'</td>';
								echo '<td>'.$keys[$count].'</td>';
								echo '<td>'.'www.'.$keys[$count].'.av.ke.</td>';
								echo '<td>'.number_format($promoters_web_array[$keys[$count]]).'</td>';
echo "</tr>";

}

echo "<tr>";
								echo '<td>---</td>';
								echo '<td>---</td>';
								echo '<td>---</td>';
								echo '<td>---</td>';
echo "</tr>";

$x=$user_web_position;
for($count=($x-2);$count<=($x+2);$count++){
	
	$position=$count+1;

	//prevent position being 0 or negative
	if($position>4&&$position<$number_of_users){

if($count==$user_web_position){
			echo "<tr bgcolor='#D9EDF7'>";
		}else{
			echo "<tr>";
		}
								echo '<td>'.$position.'</td>';
								echo '<td>'.$keys[$count].'</td>';
								echo '<td>'.'www.'.$keys[$count].'.av.ke.</td>';
								echo '<td>'.number_format($promoters_web_array[$keys[$count]]).'</td>';
echo "</tr>";
}


}

				
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

<div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="submitBrandForm" action="php_action/createBrand.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-usd"></i> Withdraw Cash</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="add-brand-messages"></div>

	        <div class="form-group">
	        	<label for="brandName" class="col-sm-4 control-label">Withdraw Earnings</label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <input type="text" style="font-weight: bold;" readonly="readonly" class="form-control" id="brandName" placeholder="Brand Name" name="brandName" autocomplete="off" value="<?php 
		    	echo "KSh. ".$totalEarningsAvailable ; ?>">
		    		<input type="hidden"  name="revenue" id="revenue" value="<?php echo $totalEarningsAvailable; ?>">
				    </div>
	        </div> <!-- /form-group-->	         	        
	        <div class="form-group">
	        	<label for="brandStatus" class="col-sm-4 control-label">Payment Method</label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <select class="form-control" id="brandStatus" name="brandStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="Cash">Cash</option>
				      	<option value="Mpesa">Mpesa</option>
				      	<option value="Airtel Money">Airtel Money</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	         	        

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        
	        <button type="submit" class="btn btn-primary" id="createBrandBtn" data-loading-text="Loading..." autocomplete="off">Save Changes</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>
	     <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- / add modal -->

<!-- edit brand -->
<div class="modal fade" id="editBrandModel" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="editBrandForm" action="php_action/editBrand.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Brand</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="edit-brand-messages"></div>

	      	<div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
					</div>

		      <div class="edit-brand-result">
		      	<div class="form-group">
		        	<label for="editBrandName" class="col-sm-3 control-label">Brand Name: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="editBrandName" placeholder="Brand Name" name="editBrandName" autocomplete="off">
					    </div>
		        </div> <!-- /form-group-->	         	        
		        <div class="form-group">
		        	<label for="editBrandStatus" class="col-sm-3 control-label">Status: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <select class="form-control" id="editBrandStatus" name="editBrandStatus">
					      	<option value="">~~SELECT~~</option>
					      	<option value="1">Available</option>
					      	<option value="2">Not Available</option>
					      </select>
					    </div>
		        </div> <!-- /form-group-->	
		      </div>         	        
		      <!-- /edit brand result -->

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer editBrandFooter">
	        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
	        
	        <button type="submit" class="btn btn-success" id="editBrandBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>
	     <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- / add modal -->
<!-- /edit brand -->

<!-- remove brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeMemberModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Brand</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer removeBrandFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="removeBrandBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove brand -->

<script type="text/javascript">

$(document).ready(function() {
	// top bar active
	$('#navRank').addClass('active');

});
</script>

<?php require_once 'includes/footer.php'; ?>