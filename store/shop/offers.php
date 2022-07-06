<?php include 'header.php'; ?>	


<?php

if(isset($_GET['offer'])){
    $offer=$_GET['offer'];

$sql="SELECT * FROM offers2 WHERE id='$offer'";
}else{
$sql="SELECT * FROM offers2 WHERE status=1 ORDER BY id DESC ";
}
$result=$connect->query($sql);

//set more than one offer as false. To be set as true when product supplier id matches supplier id
$more_than_one_offer=false;

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
    $image_url=str_replace("assests","https://promote.javy.co.ke/assests", $row['image']);
    $product_id=$row['product_id'];

       if(strpos($image_url, '.php') !== false){
            $image_url=$image_url."?image_on_store=".$storename;
        }

    $sqlproduct="SELECT name,image,price,profit,supplier_id FROM products WHERE id='$product_id'";
    $result2=$connect->query($sqlproduct);
    while($row=$result2->fetch_assoc()){
        $product_name=$row['name'];
        $product_price=$row['price'];
        $product_image=$row['image'];
        $product_image=str_replace("..", "https://promote.javy.co.ke/", $row['image']);
        $product_profit=$row['profit'];
        $supplier_id=$row['supplier_id'];


    if($id==$supplier_id){

        $more_than_one_offer=true;

?>

        <div class="panel panel-default" id="offer<?php echo $offer_id;?>">
            <div class="panel-heading">
            <h3 style="text-align: center;"><?php echo $title; ?></h3>
            </div>
            <!-- /panel-heading -->
            <div class="panel-body">

            <div class="col-md-8">
            <a href="product.php?id=<?php echo $product_id;?>">
            <img src="<?php echo $image_url; ?>" alt="<?php echo $product_name; ?>" width="100%" />
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
                        <li><a href="http://www.facebook.com/sharer.php?u=<?php echo $host.'/offers.php?offer='.$offer_id; ?>" target="_blank" class="fa fa-facebook icon facebook"></a></li>
                        <!--<li><a href="#" class="fa fa-facebook icon facebook"> </a></li>-->
                        
                        <li><a href="https://twitter.com/share?url=<?php echo 'http://'.$storename.'.av.ke/offers.php?offer='.$offer_id; ?>&amp;text=<?php echo 'Offer on '.$product_name;?>" target="_blank" class="fa fa-twitter icon twitter"> </a></li>

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
        <?php 

    }
    }
    }

    if($more_than_one_offer==false){
    echo "<h1 style='text-align:center; margin:30px;'>No offers at the moment.</h1>";
}
?>


<?php include'footer.php'; ?>	