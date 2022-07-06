<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$productName 		= addslashes($_POST['productName']);
  // $productImage 	= $_POST['productImage'];
 // $quantity 			= $_POST['quasntity'];
  //$rate 					= $_POST['rate'];
  $price 					= $_POST['price'];
  $cost 					= $_POST['cost'];
  $commission				=$_POST['commission'];
  $brandName 			= $_POST['brandName'];
  $categorySlug 			= $_POST['categoryName'];
  $shortDescription 	= addslashes(nl2br($_POST['shortDescription']));
  $date=time();

//work on registered on to find out which store the supplier signed up on
  $sqlusers ="SELECT * FROM suppliers WHERE id = $userId";
$userResult=$connect->query($sqlusers);
$userResult=$userResult->fetch_assoc();
$registered_on=$userResult['registered_on'];

/* 
Image upload
  	$product_image_name = $_FILES['productImage']['name'];
	$type = explode('.', $_FILES['productImage']['name']);
	$type = $type[count($type)-1];	
	$uniqid = uniqid(rand());	
	$url = '../../javy-promote/assests/images/product-images/'.$categorySlug.'/'.$brandName.'/'.$uniqid.'.'.$type;
	$url_on_database = '../assests/images/product-images/'.$categorySlug.'/'.$brandName.'/'.$uniqid.'.'.$type;
	$new_product_image_name=$uniqid.'.'.$type;
	
	if(@is_array(getimagesize($_FILES['productImage']['tmp_name']))) {
		if(is_uploaded_file($_FILES['productImage']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['productImage']['tmp_name'], $url)) {
				*/

$query='SELECT * FROM products';
$query_run=$connect->query($query);
$rows=$query_run->num_rows;

$array_slug=[];

function form_slug($name){ 

        $name=str_replace(' ', '_', $name);
        $name=str_replace('"', '', $name);
        $name=str_replace('”', '', $name);
        $name=str_replace('“', '', $name);
        $name=str_replace('#', '', $name);
        $name=str_replace('&', '', $name);
        $name=str_replace('+', '', $name);
        $name=str_replace('@', '', $name);
        $name=str_replace('-', '', $name);
        $name=str_replace(',', '', $name);
        
        $slug=strtolower($name);
        return $slug;

}

while($row=$query_run->fetch_assoc()){

        $name=$row['name'];
        $product_id=$row['id'];
            
        
        $slug=form_slug($name);

        array_push($array_slug, $slug);
        
        }

        $found=false;
        $count=0;

        $slug=form_slug($productName);

        foreach ($array_slug as $value) 
        {
          if($value==$slug){
            $found=true;
            $count++;
          }
        }

        if($found){
          //echo "Doubled ";
          $slug=$slug.'_'.strval($count);
        }
				
				$sql = "INSERT INTO products VALUES (NULL,'$productName','','', '$price', '$shortDescription','', '$commission','$cost', '$categorySlug','$brandName', 1,0,0,0,'','',$userId,$registered_on,'$slug','','',0,$date)";

				if($connect->query($sql) === TRUE) {

					$product_id = $connect->insert_id;

					//product images sql
					//$sql_product_image = "INSERT INTO product_images VALUES (NULL,'$product_id','$product_image_name','$new_product_image_name')";
					
					//$connect->query($sql_product_image); 

					$valid['success'] = true;
					$valid['id']=$product_id;
					$valid['messages'] = "Successfully Added.";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while adding the product";
				}
				/*
			}	else {
				return false;
			}	// /else	
		} // if
	} // if in_array 
	*/		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST