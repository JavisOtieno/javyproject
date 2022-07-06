<?php 

include 'header.php';


$query_products=$query2="SELECT * FROM products WHERE category='tvs' AND supplier_id=1 AND link LIKE '%kenyatronics%' ORDER BY brand,price DESC";

$query_run_products=mysqli_query($db_link,$query_products);
$number_of_products=mysqli_num_rows($query_run_products);

echo 'Number of products to be adjusted : '.$number_of_products;

$current_brand='';

while($row=mysqli_fetch_assoc($query_run_products)){

	if($row['brand']!=$current_brand){
		echo '<br/><br/>'.strtoupper($row['brand']).'<br/>';
	}

	$price=$row['price'];
	$product_id=$row['id'];

	echo $row['name'].' '.number_format($price).' ';

	//prices between 5k and 10k
	//add on 3k
	if($price>=5000 && $price<9999){
		$new_price=$price+3000;
	}
	else if($price>=10000 && $price<19999){
		$new_price=$price+4000;
	}else if($price>=20000 && $price<29999){
		$new_price=$price+2500;
	}else if($price>=30000 && $price<39999){
		$new_price=$price+3500;
	}else if($price>=40000 && $price<49999){
		$new_price=$price+4500;
	}else if($price>=50000 && $price<59999){
		$new_price=$price+5500;
	}else if($price>=60000 && $price<69999){
		$new_price=$price+6500;
	}else if($price>=70000 && $price<79999){
		$new_price=$price+7500;
	}else if($price>=80000 && $price<89999){
		$new_price=$price+8500;
	}else if($price>=90000 && $price<149999){
		$new_price=$price+13000;
	}else if($price>=150000){
		$new_price=$price+round((0.1*$price), -3);
	}

	echo "new price ".number_format($new_price)."<br/>";

	//prices between 10k and 20k
	//add on 4k
	//prices between 20k and 30k
	//add on 2,500
	//prices between 30k and 40k
	//add on 3,500
	//prices between 40k and 50k 
	//add on 4,500
	//prices between 50k and 60k
	//add on 5,500 
	//prices between 60k and 70k
	//add on 6,500
	//prices between 70k and 80k
	//add on 7,500
	//prices between 80k and 90k
	//add on 8,500
	//prices 90k to 150k
	//add on 13k
	//prices 150k to 200k
	//add on 18k
	//prices 200k to 300k
	//add on 25k
	//prices 300k to 500k
	//add on 40k

	$current_brand=$row['brand'];

	if($row['brand']=='syinix'){

		$query_update_price=$query2="UPDATE products SET price='$new_price' WHERE id='$product_id'";

		//activate only on update
		//$query_run_update_price=mysqli_query($db_link,$query_update_price);

		//echo "PRICE UPDATED<br>";

	}



}


?>