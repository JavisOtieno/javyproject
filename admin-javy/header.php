<?php include 'core.php'; ?>
<?php include 'connect.inc.php';

date_default_timezone_set("Africa/Nairobi");

$uri=$_SERVER['REQUEST_URI'];
$split_url_pieces_stroke = explode("/", $uri);
$directory=$split_url_pieces_stroke[1];

if($directory=="websites"){
  $directory=$split_url_pieces_stroke[3];
}

if( $directory=="scrape"){
    $folder_up='../../';
}else if($directory=="add" OR $directory=="delete" OR $directory=="edit"){
  $folder_up='../';
}
else{
  $folder_up='';
}



 ?>

<html>
<head>

<!-- bootstrap -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" integrity="sha512-wtjMa8AnvUyCbLxFg1jLR88gSACq81IiYgtIVdeNo3k+M8rdo4JdfScn7WxbZDsxZxFyDOEpMqOvYCzpSM6hnw==" crossorigin="anonymous" />
   <!-- bootstrap js -->

     <script src="<?php echo $folder_up; ?>jquery/jquery.min.js"></script>

  <!--favicon-->
  <link rel="icon" href="icon.png" />
  <!--//tags -->

  <title>Admin Javy | Control Center</title>

   </head>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo $folder_up; ?>index.php">Javy Administrator</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav" style="float: right;">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo $folder_up; ?>index.php">Home <span class="sr-only">(current)</span></a>
      </li>

      
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $folder_up; ?>orders.php">Orders</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?php echo $folder_up; ?>products.php">Products</a>
      </li>

     
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $folder_up; ?>categories-and-brands.php">Categories and Brands</a>
      </li>
       <?php if($userId == 1)
  {
    echo '

       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Designs
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="'.$folder_up.'offers.php">Offers</a>
          <a class="dropdown-item" href="'.$folder_up.'banners.php">Banners</a> 
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="'.$folder_up.'media.php">Media</a>
      </li>
          <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Users
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="'.$folder_up.'promoters.php">Promoters</a>
          <a class="dropdown-item" href="'.$folder_up.'suppliers.php">Suppliers</a>
          <a class="dropdown-item" href="'.$folder_up.'customers.php">Customers</a>
          <a class="dropdown-item" href="'.$folder_up.'promoters-subscribers.php">Promoters Email Subscribers</a>
          <a class="dropdown-item" href="'.$folder_up.'customers-subscribers.php">Customers Email Subscribers</a>
       
        </div>
      </li>

      <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Messages & Email
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="'.$folder_up.'product-messages.php">Product Messages</a>
          <a class="dropdown-item" href="'.$folder_up.'customer-contact-forms.php">Customer Contact Forms</a>
          <a class="dropdown-item" href="'.$folder_up.'customer-queries.php">Customer Queries</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="'.$folder_up.'customer-emails.php">Customer Emails</a>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="'.$folder_up.'send/send-report-emails.php">Send Report Emails</a>
          <a class="dropdown-item" href="'.$folder_up.'send/send-customer-emails.php">Send Customer Emails</a>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="'.$folder_up.'newsletter-products.php">Newsletter Products</a>

          <div class="dropdown-divider"></div>
        </div>
      </li>';
    }
      echo'
      <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Update
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="'.$folder_up.'scrape/list-products-on-javy.php">Products Link List</a>
          <a class="dropdown-item" href="'.$folder_up.'scrape/pnt-wp/update-prices.php">PNT Update Prices</a>
          <a class="dropdown-item" href="'.$folder_up.'scrape/pnt-wp/products-list.php">PNT Products List</a>
          <a class="dropdown-item" href="'.$folder_up.'scrape/pnt-wp/add-product.php?link=">Add PNT Product</a>
          <a class="dropdown-item" href="'.$folder_up.'scrape/kenyatronics/update-prices.php">KNT Update Prices</a>
          <a class="dropdown-item" href="'.$folder_up.'scrape/kenyatronics/products-list.php">KNT Products List</a>
          <a class="dropdown-item" href="'.$folder_up.'scrape/kenyatronics/add-product.php?link=">Add KNT Product</a>
          <a class="dropdown-item" href="'.$folder_up.'scrape/ramtons/update-prices.php">Ramtons Update Prices</a>
          <a class="dropdown-item" href="'.$folder_up.'scrape/ramtons/products-list.php">Ramtons Products List</a>
          <a class="dropdown-item" href="'.$folder_up.'scrape/ramtons/add-product.php?link=">Add Ramtons Product</a>
          <a class="dropdown-item" href="'.$folder_up.'scrape/wordpress/update-prices.php">WP Update Prices</a>
          <a class="dropdown-item" href="'.$folder_up.'scrape/wordpress/products-list.php">WP Products List</a>
          <a class="dropdown-item" href="'.$folder_up.'scrape/wordpress/add-product.php?link=">Add WP Product</a>';

          if($userId == 1){
          echo '
           <a class="dropdown-item" href="'.$folder_up.'promoter-contacts.php">Promoter Contacts</a>
           <a class="dropdown-item" href="'.$folder_up.'customer-contacts.php">Customer Contacts</a>
           <a class="dropdown-item" href="'.$folder_up.'supplier-contacts.php">Supplier Contacts</a>';
         }

           echo '
        </div>
      </li>';

      if($userId == 1){
        echo '
       <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Cash
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="'.$folder_up.'payments.php">Supplier Payments</a>
          <a class="dropdown-item" href="'.$folder_up.'withdrawals.php">Promoter Withdrawals</a>
        </div>
      </li>';
       }
      ?>

      <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Add
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
           <?php if($userId == 1) {
            //nothing here yet
           }
    echo '<a class="dropdown-item" href="'.$folder_up.'add/add-enquiry.php">Enquiry</a>';
    echo '<a class="dropdown-item" href="'.$folder_up.'add/add-order.php">Order</a>';
    echo '<a class="dropdown-item" href="'.$folder_up.'add/add-product.php">Product</a>';
    ?>
          
           <?php if($userId == 1) {
    echo '<a class="dropdown-item" href="'.$folder_up.'add/add-offer.php">Offer</a>
          <a class="dropdown-item" href="'.$folder_up.'add/add-banner.php">Banner</a>';
  }
  echo '<a class="dropdown-item" href="'.$folder_up.'add/add-category.php">Category</a>
          <a class="dropdown-item" href="'.$folder_up.'add/add-brand.php">Brand</a>';
  ?>
          
          
        </div>
      </li>

      <?php if($userId == 1)
  {
    echo '
      <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Others
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="'.$folder_up.'pricelists.php">Pricelists</a>
          <a class="dropdown-item" href="'.$folder_up.'ranking.php">Ranking</a>
          <a class="dropdown-item" href="'.$folder_up.'reset-passwords.php">Reset Passwords</a>
          <a class="dropdown-item" href="'.$folder_up.'graph.php">Graph</a>
          <a class="dropdown-item" href="'.$folder_up.'suggestions.php">Marketing Suggestions</a>
          
        </div>
      </li>';
    }
    ?>

      <li class="nav-item">
        <a class="nav-link" href="<?php echo $folder_up; ?>logout.php">Log Out</a>
      </li>

      

      
      <!--<li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>-->
    </ul>
  </div>
</nav>





<body>

