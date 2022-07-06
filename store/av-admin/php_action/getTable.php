<?php
include 'core.php';
include 'db_connect.php';
?>

<table class="table" id="manageBrandTable2">
					<thead>
					<caption style="text-align: center; font-size: 20px;color: #000000;">WITHDRAWALS</caption>
						<tr>							
							<th>Date and Time</th>
							<th>Withdrawal Amount</th>
							<th>Payment Method</th>
							<th style="width:15%;">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqlwithdrawals="SELECT * FROM withdrawals WHERE user_id='$userId' ORDER BY Withdrawal_id DESC";
						$withdrawalsResult=$connect->query($sqlwithdrawals);

						if($withdrawalsResult->num_rows>0){
							while($row=$withdrawalsResult->fetch_assoc()){
								echo "<tr>";
								echo '<td>'.$row['date'].'</td>';
								echo '<td>'.$row['amount'].'</td>';
								echo '<td>'.$row['method'].'</td>';

								if($row['status'] == 1) {
								 		// activate member
								 		$withdrawalStatus = "<label class='label label-success'>Completed</label>";
								 	} else if($row['status'] == 0) {
								 		// deactivate member
								 		$withdrawalStatus = "<label class='label label-warning'>Processing ...</label>";
								 	}else{
								 		$withdrawalStatus = "<label class='label label-danger'>Cancelled</label>";
								 	}

								echo '<td>'.$withdrawalStatus.'</td>';

								echo "</tr>";
							}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No deals so far</td></tr>";
						}
						
						$connect->close();
						?>
					</tbody>
			</table>