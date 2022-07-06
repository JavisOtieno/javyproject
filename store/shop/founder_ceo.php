<?php include'header.php'; ?>	

<style type="text/css">
	/* Three columns side by side */
.column {
    float: left;
    width: 66.6%;
    margin-bottom: 16px;
    margin-left: 16.65%;
    margin-right: 16..65%;
    padding: 0 8px;
}

 #image{
    	width: 50%;
    }

    #founder_details{
    	width:50%;
    	float: right;
    }
    

/* Display the columns below each other instead of side by side on small screens */
@media (max-width: 650px) {
    .column {
       
        display: block;
    }

     #image{
    	width: 100%;
    }

    #founder_details{
    	margin-top: 15px;
    	width:100%;
    	float: none;
    	margin-bottom: 50px;
    }

}

/* Add some shadows to create a card effect */
.card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

/* Some left and right padding inside the container */
.container {
    padding: 0 16px;
}

/* Clear floats */
.container::after, .row::after {
    content: "";
    clear: both;
    display: table;
}


/*
.button {
    border: none;
    outline: 0;
    display: inline-block;
    padding: 8px;
    color: white;
    background-color: #000;
    text-align: center;
    cursor: pointer;
    width: 33.3%;
}

.button:hover {
    background-color: #555;
}
*/
</style>
<br/ ><br/ >
<h3 class="w3ls-title w3ls-title1">Founder & CEO</h3>


<?php if(!$show_founder){echo "<!--";} ?>
<div class="row">
  <div class="column">
    <div class="card">

        <?php
                        if (empty($profile_picture))
                        {
                            echo "<img src='img1.jpg' id='image'>";
                        }
                        else{
                            //localhost code
                            //echo "<img id='image' style='max-width:500px; max-height:333px;' src='../stock-2/assests/images/profile-pictures/".$profile_picture."?".mt_rand()."'>";

                            //web code
                            echo "<img id='image' style='max-width:500px; max-height:333px;' src='https://javy.co.ke/assests/images/profile-pictures/".$profile_picture."?".mt_rand()."'>";

                        }
                        ?>
      
      <div class="container" id="founder_details" >
        <h2><?php echo $name; ?></h2><br/ >
        
        <p>I was very happy to launch my own ecommerce store and I hope that you'll have an amazing shopping experience on it.</p>
        

        
      </div>
    </div>
  </div>
  </div>

  <?php if(!$show_founder){echo " -->";} ?>

  <?php if(!$show_founder){echo "<h3 style='margin-left: 10px;''>Sorry the founder and CEO details are private on this site!</h3><br/ ><br/ >";} ?>

  



<?php include'footer.php'; ?>	