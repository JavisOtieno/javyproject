<?php include 'core-folder-up.php'; ?>
<?php include 'connect.inc.php';
date_default_timezone_set("Africa/Nairobi");
 ?>

<html>
<head>

<!-- bootstrap -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <!-- bootstrap js -->
     <script src="../jquery/jquery.min.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.min.js"></script> 

  <!--favicon-->
  <link rel="icon" href="icon.png" />
  <!--//tags -->

  <title>Admin Javy | Control Center</title>


   </head>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="../index.php">Javy Administrator</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav" style="float: right;">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
      </li>
       <?php if($userId == 1)
  {
  
    echo ' <li class="nav-item">
        <a class="nav-link" href="../orders.php">Orders</a>
      </li>';
  }
  ?>
     
      <li class="nav-item">
        <a class="nav-link" href="../products.php">Products</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../categories-and-brands.php">Categories and Brands</a>
      </li>
      <?php if($userId == 1)
  {

    echo '
      <li class="nav-item">
        <a class="nav-link" href="../offers.php">Offers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../media.php">Media</a>
      </li>
          <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Users
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../../promoters.php">Promoters</a>
          <a class="dropdown-item" href="../../suppliers.php">Suppliers</a>
          <a class="dropdown-item" href="../../customers.php">Customers</a>
          <a class="dropdown-item" href="../../promoters-subscribers.php">Promoters Email Subscribers</a>
       
        </div>
      </li>

      <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Messages & Email
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../../product-messages.php">Product Messages</a>
          <a class="dropdown-item" href="../../customer-contact-forms.php">Customer Contact Forms</a>
          <a class="dropdown-item" href="../../customer-queries.php">Customer Queries</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../../customer-emails.php">Customer Emails</a>
        </div>
      </li>

       <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Cash
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../../payments.php">Supplier Payments</a>
          <a class="dropdown-item" href="../../withdrawals.php">Promoter Withdrawals</a>
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
    echo '<a class="dropdown-item" href="../../add/add-order.php">Order</a>';
  }?>
          <a class="dropdown-item" href="../add/add-product.php">Product</a>
          <?php if($userId == 1) {
    echo '<a class="dropdown-item" href="../add/add-offer.php">Offer</a>';
  }?>
          
          <a class="dropdown-item" href="../add/add-category.php">Category</a>
          <a class="dropdown-item" href="../add/add-brand.php">Brand</a>
          
        </div>
      </li>

  <?php if($userId == 1)
  {
    echo ' <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Others
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../pricelists.php">Pricelists</a>
          <a class="dropdown-item" href="../ranking.php">Ranking</a>
          <a class="dropdown-item" href="../reset-passwords.php">Reset Passwords</a>
          
        </div>
      </li>';
  }
  ?>   

     

      <li class="nav-item">
        <a class="nav-link" href="../logout.php">Log Out</a>
      </li>

      

      
      <!--<li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>-->
    </ul>
  </div>
</nav>



<body>

