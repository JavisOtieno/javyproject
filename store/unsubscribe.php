<?php
require('connect.inc.php');

require('subdomain_storename.php');


//getting the phone number
$query="SELECT * FROM `users` WHERE `storename` ='$storename'";

$query_run=mysqli_query($db_link,$query);
if(mysqli_num_rows($query_run)==0){
  echo "<script type='text/javascript'>
window.location.href = 'find.php';
</script>";
}
if($row=mysqli_fetch_assoc($query_run)){
  
  $phone_number=$row['phone'];
  $email=$row['email'];
  if(strlen($email)<1){
    $email="info@javy.co.ke";
  }

  $display_phone=$row['display_phone'];
  $display_email=$row['display_email'];

  if($display_phone!=""){
    $phone_number=$display_phone;
  }
  if($display_email!=""){
    $email=$display_email;
  }


  $user_id=$row['user_id'];
  $name=$row['firstname'].' '.$row['lastname'];
  $show_founder=$row['show_founder'];
  $created_on=$row['created_on'];
  $facebook_link=$row['facebook_link'];
  $twitter_link=$row['twitter_link'];
  $instagram_link=$row['instagram_link'];
  $profile_picture=$row['profile_picture'];
  $shop_type=$row['shop_type'];
}

?><!DOCTYPE html>
<html lang="en">
<head>

<title><?php echo ucfirst($storename) ?> | Online Store - Electronics and many more products</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo ucfirst($storename) ?> | For all your electronics in Kenya. Shop online for phones, cameras, laptops, tvs, home theatre systems and accessories " />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
    function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--favicon-->
<link rel="icon" href="icon.gif" />
<!-- Custom Theme files -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" /> 
<link href="css/menu.css" rel="stylesheet" type="text/css" media="all" /> <!-- menu style --> 
<link href="css/ken-burns.css" rel="stylesheet" type="text/css" media="all" /> <!-- banner slider --> 
<link href="css/animate.min.css" rel="stylesheet" type="text/css" media="all" /> 
<link href="css/owl.carousel.css" rel="stylesheet" type="text/css" media="all"> <!-- carousel slider -->  
<!-- //Custom Theme files -->
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<!-- js -->
<script src="js/jquery-2.2.3.min.js"></script> 
<!-- //js --> 
<!-- web-fonts -->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Lovers+Quarrel' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Offside' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Tangerine:400,700' rel='stylesheet' type='text/css'>
<!-- web-fonts --> 
<script src="js/owl.carousel.js"></script>  
<script>
$(document).ready(function() { 
  $("#owl-demo").owlCarousel({ 
    autoPlay: 3000, //Set AutoPlay to 3 seconds 
    items :4,
    itemsDesktop : [640,5],
    itemsDesktopSmall : [480,2],
    navigation : true
 
  }); 
}); 
</script>
<script src="js/jquery-scrolltofixed-min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {

        // Dock the header to the top of the window when scrolled past the banner. This is the default behaviour.

        $('.header-two').scrollToFixed();  
        // previous summary up the page.

        var summaries = $('.summary');
        summaries.each(function(i) {
            var summary = $(summaries[i]);
            var next = summaries[i + 1];

            summary.scrollToFixed({
                marginTop: $('.header-two').outerHeight(true) + 10, 
                zIndex: 999
            });
        });
    });
</script>
<!-- start-smooth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script> 
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $(".scroll").click(function(event){   
        event.preventDefault();
        $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
      });
    });
</script>
<!-- //end-smooth-scrolling -->
<!-- smooth-scrolling-of-move-up -->
  <script type="text/javascript">
    $(document).ready(function() {
    
      var defaults = {
        containerID: 'toTop', // fading element id
        containerHoverID: 'toTopHover', // fading element hover id
        scrollSpeed: 1200,
        easingType: 'linear' 
      };
      
      $().UItoTop({ easingType: 'easeOutQuart' });
      
    });
  </script>
  <!-- //smooth-scrolling-of-move-up -->
<script src="js/bootstrap.js"></script> 

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-68172934-9"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-68172934-9');
</script>

</head>

<?php 

if(isset($_GET['customer'])){
  $id=$_GET['customer'];
}

if(isset($_GET['subscribe'])){
  $subscribe=$_GET['subscribe'];
}

/*
$query_users='SELECT * FROM customers WHERE id="'.$customer.'"';

$query_run_users=$connect->query($query_users);

if($row=$query_run_users->fetch_assoc()){
  $id=$row['id'];
}
*/


$query_unsubscribe='SELECT * FROM unsubscribe_list_customers WHERE id='.$id;
$query_run_unsubscribe=$connect->query($query_unsubscribe);
$rows_unsubscribe=mysqli_num_rows($query_run_unsubscribe);



?>

	<title>Javy | Unsubscribe </title>
	
	<!--make site responsive on mobile phone-->
	<meta name="viewport" content="width=device-width, initial-scale=1">

  <!--favicon-->
  <link rel="icon" href="images-front/icon.png" />

	<!-- bootstrap -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme-->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

  <!-- custom css -->
  <link rel="stylesheet" href="custom/css/custom.css">

	<!-- DataTables -->
  <link rel="stylesheet" href="assests/plugins/datatables/jquery.dataTables.min.css">

  <!-- file input -->
  <link rel="stylesheet" href="assests/plugins/fileinput/css/fileinput.min.css">
  

  <!-- jquery -->
	<script src="assests/jquery/jquery.min.js"></script>
  <!-- jquery ui -->  
  <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>

  <!-- bootstrap js -->
	<script src="assests/bootstrap/js/bootstrap.min.js"></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-68172934-6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-68172934-6');
</script>


</head>
<body>


	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
  

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">    

 

      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
	</nav>

	<div class="container">






<div class="row">
  <div class="col-md-12">

    <div class="panel panel-default">
      <div class="panel-heading">

        <?php

        if($subscribe=='true'){

           if($rows_unsubscribe!=0){

        $sql ="DELETE FROM unsubscribe_list_customers WHERE id=".$id;


         if($connect->query($sql)){
        echo "<h3 style='text-align: center;'> You have been subscribed succesfully. We'll send you regular email updates</h3>";


        }else{
          echo "<h3 style='text-align: center;'>Error. Please try again.</h3>";
        }


           }else{

             echo "<h3 style='text-align: center;'>You're already subscribed to emails from us.</h3>";
           }

        }else{


 if($rows_unsubscribe==0){
       


        $sql ="INSERT INTO unsubscribe_list_customers VALUES(NULL,$id)";


         if($connect->query($sql)){
        echo "<h3 style='text-align: center;'> You have been unsubscribed. You will no longer receive our emails.</h3>";

        echo '<h4 style="text-align: center;margin-top:20px;">Changed your mind? <a href="unsubscribe.php?customer='.$id.'&subscribe=true">Click here to subscribe and receive our emails</a></h4>';


        }else{
          echo "<h3 style='text-align: center;'>Error. Please try again.</h3>";
        }


        }
        else{
          echo "<h3 style='text-align: center;'>You have already been unsubscribed from our emails.</h3>";

          echo '<h4 style="text-align: center;margin-top:20px;">Changed your mind? <a href="unsubscribe.php?customer='.$id.'&subscribe=true">Click here to subscribe and receive our emails</a></h4>';
        }

         }

         echo '<h1 style=" text-align: center;"><a href="/" style="display: inline-block;color: #000;text-decoration: none;position: relative;font-weight: 700;margin-top:20px;" >Back to <span style="font-size: 1.7em;color: #F44336;vertical-align: sub;margin-right: 3px;">'.strtoupper(substr($storename, 0, 1)).'</span>'.substr($storename,1,mb_strlen($storename)-1).'</a></h1>';

       
         ?>
        
      </div>
      <!-- /panel-heading -->
      
      </div>
      <!--offers title
      <ol class="breadcrumb">
          
      <li class="active">Promotional Images</li>
    </ol>-->


    

  

  </div>
  <!-- /col-dm-12 -->
</div>
<!-- /row -->

<script src="custom/js/report.js"></script>
<script type="text/javascript">

<?php require_once 'includes/footer.php'; ?>