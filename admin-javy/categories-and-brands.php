<?php include 'header.php'; ?>




<?php

echo '<a href="add/add-brand.php" ><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Add Brand</button></a>';
    echo '<a href="add/add-category.php" ><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Add Category</button></a>';


require 'connect.inc.php';

$query='SELECT * FROM products';


echo "<strong><br/><br/> CATEGORIES<br/></strong>";



$sql_categories="SELECT * FROM categories";
$query_run_categories=mysqli_query($db_link,$sql_categories);

echo '<div class="table-responsive"><table class="table table-striped"><tbody>';

while($row_category=mysqli_fetch_assoc($query_run_categories)){

	echo '
<tr><td>'.$row_category['categories_id'].'</td>
<td>'.$row_category['categories_name'].'</td>
<td><a href="edit/edit-category.php?id='.$row_category['categories_id'].'"><button>edit</button></a></td>
<td>'.$row_category['categories_slug'].'</td>	


</tr>';

}
echo "</tbody></table></div>";

echo "<strong><br/><br/> BRANDS<br/></strong>";


$sql_categories="SELECT * FROM categories";

$query_run_categories=mysqli_query($db_link,$sql_categories);

while($row_category=mysqli_fetch_assoc($query_run_categories)){

	echo '<br/><strong>'.$row_category['categories_name'].'</strong><br/>';

$sql_brands="SELECT * FROM brands WHERE brand_category=".$row_category['categories_id'];
$query_run_brands=mysqli_query($db_link,$sql_brands);

echo '<div class="table-responsive"><table class="table table-striped"><tbody>';

while($row_brand=mysqli_fetch_assoc($query_run_brands)){


	echo '<tr>
<td>'.$row_brand['brand_id'].'</td>
<td>'.$row_brand['brand_name'].'</td>
<td><a href="edit/edit-brand.php?id='.$row_brand['brand_id'].'"><button>edit</button></a></td>
<td>'.$row_brand['brand_slug'].'</td>	
</tr>';

}
echo "</tbody></table></div>";

	

}
include 'footer.php'; ?>
