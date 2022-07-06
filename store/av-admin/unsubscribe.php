<!DOCTYPE html>
<html>
<head>

<?php 

require_once 'php_action/db_connect.php';

if(isset($_GET['storename'])){
  $storename=$_GET['storename'];
}

if(isset($_GET['subscribe'])){
  $subscribe=$_GET['subscribe'];
}


$query_users='SELECT * FROM users WHERE storename="'.$storename.'"';

$query_run_users=$connect->query($query_users);

if($row=$query_run_users->fetch_assoc()){
  $id=$row['user_id'];
}


$query_unsubscribe='SELECT * FROM unsubscribe_list WHERE user_id='.$id;
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

        $sql ="DELETE FROM unsubscribe_list WHERE user_id=".$id;


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
       


        $sql ="INSERT INTO unsubscribe_list VALUES(NULL,$id)";


         if($connect->query($sql)){
        echo "<h3 style='text-align: center;'> You have been unsubscribed. You will no longer receive our emails.</h3>";

        echo '<h5>Changed your mind? <a href="unsubscribe.php?storename='.$storename.'&subscribe=true">Click here to subscribe and receive our emails</a></h5>';


        }else{
          echo "<h3 style='text-align: center;'>Error. Please try again.</h3>";
        }


        }
        else{
          echo "<h3 style='text-align: center;'>You have already been unsubscribed from our emails.</h3>";

          echo '<h5>Changed your mind? <a href="unsubscribe.php?storename='.$storename.'&subscribe=true">Click here to subscribe and receive our emails</a></h5>';
        }

         }

       
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