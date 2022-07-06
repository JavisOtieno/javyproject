	<!-- add-products -->
	<div class="add-products"> 
		<div class="container">  
			<div class="add-products-row">
				<?php

				$sql_category="SELECT * FROM banners WHERE status=1 ORDER BY date DESC LIMIT 3";
				$query_run_category=$connect->query($sql_category);
				$count=1;
				while($row=mysqli_fetch_assoc($query_run_category)){

					$title=$row['title'];
					$image=$row['image'];
					$price=$row['price'];
					$link=$row['link'];

					if ($count==1){
				echo '<div class="w3ls-add-grids" style=" background: url('.$image.')no-repeat 0px 0px;background-size: cover;">
					<a href="'.$link.'" > 
						<h4>'.$title.'<br />KSh. <span>'.number_format($price).'/-</span> </h4>
						<h6 style="color:#ffffff">Shop now <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
					</a>
					</div>';
					}else if ($count==2){
			echo '<div class="w3ls-add-grids w3ls-add-grids-mdl" style="background: url('.$image.')no-repeat 0px 0px;background-size: cover; ">
					<a href="'.$link.'"> 
						<h4>'.$title.'<br />KSh. <span>'.number_format($price).'/-</span> </h4>
						<h6>Shop now <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
					</a>
				</div>';
					}else if($count==3){

				echo '<div class="w3ls-add-grids w3ls-add-grids-mdl1" style="background: url('.$image.')no-repeat 0px 0px;background-size: cover; ">
					<a href="'.$link.'"> 
						<h4>'.$title.' <br />KSh. <span>'.number_format($price).'/-</span></h4>
						<h6 style="color:#ffffff">Shop now <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
					</a>
				</div>';

					}
					
					$count++;

				}

				?>

				<div class="clearfix"> </div>
			</div>  	
		</div>  	
	</div>