<?php include 'header.php'; ?>	


<?php

if(isset($_GET['offer'])){
    $offer=$_GET['offer'];

$sql="SELECT * FROM offers2 WHERE id='$offer'";
}else{
$sql="SELECT * FROM offers2 WHERE status=1 ORDER BY id DESC LIMIT 10";
}
$result=$connect->query($sql);


?>

<div class="row">
    <div class="col-md-12">

    <ol class="breadcrumb">
          <li><a href="dashboard.php">Home</a></li>       
          <li class="active">Offers</li>
        </ol>
<?php


while ($row=$result->fetch_assoc()){
    
    $offer_id=$row['id'];
    $title=$row['title'];
    $image_url=$row['image'];
    if($image_url==''){
        $image_url=$row['original_image'];
    }
    $image_url=str_replace("assests","https://promote.javy.co.ke/assests", $image_url);
    $product_id=$row['product_id'];

       if(strpos($image_url, '.php') !== false){
            $image_url=$image_url."?image_on_store=".$storename;
        }

    $sqlproduct="SELECT * FROM products WHERE id='$product_id'";
    $result2=$connect->query($sqlproduct);
    while($row=$result2->fetch_assoc()){
        $product_name=$row['name'];
        $product_price=$row['price'];
        $product_image=$row['image'];
        $product_image=str_replace("..", "https://promote.javy.co.ke/", $row['image']);
        $product_profit=$row['profit'];
        $product_category=$row['category'];


    }

    $sqlshoptype="SELECT shop_type FROM categories WHERE categories_slug='$product_category'";
    $resultshoptype=$connect->query($sqlshoptype);
    while($rowshoptype=$resultshoptype->fetch_assoc()){
        
        $shop_type_on_offer=$rowshoptype['shop_type'];
       
    }


if(($shop_type==$shop_type_on_offer) || ($shop_type==0) ){
    



?>

        <div class="panel panel-default" id="offer<?php echo $offer_id;?>">
            <div class="panel-heading">
            <h3 style="text-align: center;"><?php echo $title; ?></h3>
            </div>
            <!-- /panel-heading -->
            <div class="panel-body">

            <div class="col-md-8">
            <a href="product.php?id=<?php echo $product_id;?>">
            <img src="<?php echo $image_url; ?>" alt="<?php //echo $product_name; ?>" width="100%" />
            </a>
            </div>
            <div class="col-md-4">
            <a href="product.php?id=<?php echo $product_id;?>">
            <img src="<?php echo $product_image;?>" alt="<?php echo $product_name; ?>" width="70%" style="margin: 0 15%";/>
            <h3 style="text-align: center;"><?php echo $product_name; ?></h3><br/ >
            <h4 style="text-align: center;"><?php echo "Price: Ksh. ".number_format($product_price); ?></h4>
            <br/ >
            <button  type="submit" class="btn btn-success" id="generateReportBtn" style="margin: 0 30%;width:40%"> <i class="glyphicon glyphicon-ok-sign"></i> View</button></a>

            <div class="single-page-icons social-icons" style="margin: 1em 25%; width: 50%;"> 
                    <ul>
                        <li><h4>Share on:</h4></li><br/>
                        <li><a href="https://www.facebook.com/sharer.php?u=<?php echo $host.'/offers.php?offer='.$offer_id; ?>" target="_blank" class="fa fa-facebook icon facebook"></a></li>
                        <!--<li><a href="#" class="fa fa-facebook icon facebook"> </a></li>-->
                        
                        <li><a href="https://twitter.com/share?url=<?php echo 'https://'.$storename.'.av.ke/offers.php?offer='.$offer_id; ?>&amp;text=<?php echo 'Offer on '.$product_name;?>" target="_blank" class="fa fa-twitter icon twitter"> </a></li>

                        <li><a href="whatsapp://send?text=<?php echo 'Offer on http://'.$storename.'.av.ke/offers.php?offer='.$offer_id; ?>" data-action="share/whatsapp/share" class="fa fa-whatsapp icon whatsapp" ></a></li>

                        <!--<li><a href="#" class="fa fa-instagram icon fa-instagram"> </a></li>-->
                        <!--<li><a href="#" class="fa fa-dribbble icon dribbble"> </a></li>
                        <li><a href="#" class="fa fa-rss icon rss"> </a></li> -->
                    </ul>
                </div>
                
        
        <br/>
            </div>

            


                
                
            </div>
            <!-- /panel-body -->
        </div>
        </br>
        </br>
        <?php }
        }
?>


<?php include'footer.php'; ?>	