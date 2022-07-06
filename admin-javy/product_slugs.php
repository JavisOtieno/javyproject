<?php

require 'connect.inc.php';

$query_slug_clear='UPDATE products SET slug=""';
$query_run_slug_clear=mysqli_query($db_link,$query_slug_clear);

$query='SELECT * FROM products';

//Test purposes Javis and Javy Technologies

//users email to remove unsubscribers
//$query='SELECT * FROM users WHERE user_id NOT IN (SELECT user_id FROM unsubscribe_list)';


$query_run=mysqli_query($db_link,$query);

$rows=mysqli_num_rows($query_run);

$array_slug=[];

while($row=mysqli_fetch_assoc($query_run)){

  			$name=$row['name'];
  			$product_id=$row['id'];
  			
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

        $found=false;
        $count=0;

        foreach ($array_slug as $value) 
        {
          if($value==$slug){
            $found=true;
            $count++;
          }
        }

        array_push($array_slug, $slug);

        if($found){
          echo "Doubled ";
          $slug=$slug.'_'.strval($count);
        }


        echo $slug.'<br/>';
        

         /*$query_exist_slug='SELECT * FROM products WHERE slug LIKE "%'.$slug.'%"';
        $query_run_exist_slug=mysqli_query($db_link,$query_exist_slug);
        $rows_exist_slug=mysqli_num_rows($query_run_exist_slug);
        if($rows_exist_slug==0){
          $count=0;
        }else{
          $count=$rows_exist_slug+1;
          echo " Doubled ";
          echo $query_exist_slug;
          $slug=$slug.'_'.strval($count);
        }
        echo "Num : ".strval($rows_exist_slug);
        

       
        while($count){
        echo " Doubled ";
        $slug=$slug.'_'.strval($count);
        //echo $slug;

        $query_exist_slug='SELECT * FROM products WHERE slug="'.$slug.'"';
        $query_run_exist_slug=mysqli_query($db_link,$query_exist_slug);
        $rows_exist_slug=mysqli_num_rows($query_run_exist_slug);
        echo "Num : ".strval($rows_exist_slug);
        echo "Count : ".strval($count);
        //echo $query_exist_slug;
        if($rows_exist_slug==0){
          $count=0;
        }else{
          $count++;
        }

        }

        $count=0;

        */

  			$query_slug='UPDATE products SET slug="'.$slug.'" WHERE id="'.$product_id.'"';
			  $query_run_slug=mysqli_query($db_link,$query_slug);
		

		}


?>