<?php
$sql="SELECT * FROM offers_videos WHERE status=1 ORDER BY id DESC LIMIT 10";
if(isset($_GET['view_all'])){

	$view_all=$_GET['view_all'];
	if($view_all=='view_all'){
	$sql="SELECT * FROM offers_videos WHERE status=1 ORDER BY id DESC ";
}else{
	$sql="SELECT * FROM offers_videos WHERE status=1 ORDER BY id DESC LIMIT 10";
}

}

$result=$connect->query($sql);

?>


<div class="row">
	<div class="col-md-12">

	<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Promote</li>
		</ol>

		<div class="panel panel-default" id="offer<?php echo $offer_id;?>">
			<div class="panel-heading">
			<h3 style="text-align: center;"><?php echo 'Promote website: www.'.$storename.$website_ke; ?></h3>
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">
			<div class="col-md-6" id="copyText">
				<div>
			 <?php $textToshare = ' Hello, I set up my online store. Enjoy shopping at: http://www.'.$storename.$website_ke;
			 echo 'COPY TEXT THAT YOU CAN SHARE:<br/>'. $textToshare;
			 ?>
			</div>

		

			 </div>
			 <!--

			 <div class="col-md-3" style="margin-bottom: 10px;" ><button id="copyButton" style="-webkit-appearance:none;" onclick="copyToClipboard('copyText')" >
			  Copy text <i class="fa fa-copy" style="font-size: 32px;margin-left:5px;margin-right:  45px;"></i></button>
			 </div>-->
			 <div class="col-md-6">
			 <ul style="text-align: center;margin-bottom: 1">

			

						Share on
						<a href="http://www.facebook.com/sharer.php?u=http://<?php echo $storename.$website_ke; ?>/&t=visit my online store" target="_blank" class="fa fa-facebook icon facebook" style="margin-left: 5px;font-size: 32px;"></a>
						<!--<li><a href="#" class="fa fa-facebook icon facebook"> </a></li>-->
						
						<a href="https://twitter.com/share?url=http://<?php echo $storename.$website_ke; ?>/&amp;text=Hello, I set up my online store. Enjoy shopping on my website: &amp;hashtags=<?php echo $storename;?>" target="_blank" class="fa fa-twitter icon twitter" style="margin-left: 15%;font-size: 32px;"> </a>

						
						<a href="whatsapp://send?text=<?php echo $textToshare;?>" data-action="share/whatsapp/share" class="fa fa-whatsapp" style="margin-left: 15%;font-size: 32px;"></a>

					
						<!--<li><a href="#" class="fa fa-instagram icon fa-instagram"> </a></li>-->
						<!--<li><a href="#" class="fa fa-dribbble icon dribbble"> </a></li>
						<li><a href="#" class="fa fa-rss icon rss"> </a></li> -->
					
			

			</ul>
			 
			
			 </div>


			</div>



			
			</div>
			<!--offers title-->
			<ol class="breadcrumb">
		  	  
		  <li class="active">Offers</li>
		  <div class="panel-body">
					<div class="col-md-4" style="margin-top: 10px;" >
		   <div style="margin-top:20px;padding-bottom:20px;" >
					<a href="promote.php?content=images"><button style="width: 100%;" class="btn btn-default button1"> <i class="glyphicon glyphicon-image"></i> View Images </button></a>
				</div> <!-- /div-action -->	
		  </div>	

					<div class="col-md-4" style="margin-top: 10px;">
		  <div style="margin-top:20px;padding-bottom:20px;" >
					<a href="promote.php?content=videos"><button style="width: 100%;" class="btn btn-default button1"> <i class="glyphicon glyphicon-cart"></i> View Videos </button></a>
				</div> <!-- /div-action -->	
		  </div>

		  	<div class="col-md-4" style="margin-top: 10px;">
		  <div style="margin-top:20px;padding-bottom:20px;" >
					<a href="promote.php?content=more"><button style="width: 100%;" class="btn btn-default button1"> <i class="glyphicon glyphicon-cart"></i> More </button></a>
				</div> <!-- /div-action -->	
		  </div>
		  <br/><br/>
			
			</div>
		</ol>


		

		<div class="panel panel-default" id="bulk-sms">
			<div class="panel-heading">
			<h3 style="text-align: center;">Bulk SMSs</h3>
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">


			
			<div class="col-md-12">
			
			<h4 style="text-align: center;">SMS your customers with our help @ KSh. 1.50 per text. Contact us on 0716 545459 for more information</h4>
			<br/>
			
					<ul style="text-align: center;margin-bottom: 1">

				
			</div>


				
				
			</div>
			<!-- /panel-body -->
		</div>

		</br>
		</br>

		<div class="panel panel-default" id="bulk-sms">
			<div class="panel-heading">
			<h3 style="text-align: center;">Facebook Page and Instagram Profile</h3>
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">


			
			<div class="col-md-12">
			
			<h4 style="text-align: center;">Open up a <a href="https://web.facebook.com/pages/create/?ref_type=site_footer&_rdc=1&_rdr">facebook page</a> and invite your friends to like the page for starters. Keep posting on the facebook page regularly to increase awareness. You can also set up an <a href="https://www.instagram.com/?hl=en">instagram profile</a> </h4>
			<br/>
			
					<ul style="text-align: center;margin-bottom: 1">

				
			</div>


	
			</div>
			<!-- /panel-body -->
		</div>


				<div class="panel panel-default" id="bulk-sms">
			<div class="panel-heading">
			<h3 style="text-align: center;">Facebook Ads</h3>
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">


			
			<div class="col-md-12">
			
			<h4 style="text-align: center;">Once you open up a <a href="https://web.facebook.com/pages/create/?ref_type=site_footer&_rdc=1&_rdr">facebook page</a> and an <a href="https://www.instagram.com/?hl=en">instagram profile</a>, you can use <a href="https://www.facebook.com/business/ads">facebook ads</a> to increase your audience and chances of selling more. </h4>
			<br/>
			
					<ul style="text-align: center;margin-bottom: 1">

				
			</div>


	
			</div>
			<!-- /panel-body -->
		</div>


						<div class="panel panel-default" id="bulk-sms">
			<div class="panel-heading">
			<h3 style="text-align: center;">Posters/Flyers</h3>
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">


			
			<div class="col-md-12">
			
			<h4 style="text-align: center;">You can use hand out flyers or pin posters around your area for more visibility. <a href="/posters.php">Download posters</a> for printing or sharing. <!--<a href="/posters.php"> Download posters/flyers</a></h4>-->
			<br/>
			
					<ul style="text-align: center;margin-bottom: 1">

				
			</div>


	
			</div>
			<!-- /panel-body -->
		</div>








				<div class="panel panel-default" id="offer<?php echo $offer_id;?>">
			<div class="panel-heading">
			<h3 style="text-align: center;">Suggest more ways of promoting products</h3>
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">
			<div class="col-md-12" id="copyText">
				<div>
			 <h4>We welcome any suggestions that you may have on how to promote products on the website. This will help other promoters just like you. Type and submit your suggestion below.</h4>
			</div>

			<form action="php_action/submit-suggestion.php" method="post" class="form-horizontal" id="submitSuggestionForm">
				<div class="submitSuggestionMessages"></div>
<div class="form-group"> 
    <label for="suggestion">Suggestion:</label>
    <textarea class="form-control" id="suggestion" name="suggestion" rows="3"></textarea>
  </div>
  <button type="submit" class="btn btn-primary" id="submitSuggestionButton">Submit</button>
</form>
			 <!--

			 <div class="col-md-3" style="margin-bottom: 10px;" ><button id="copyButton" style="-webkit-appearance:none;" onclick="copyToClipboard('copyText')" >
			  Copy text <i class="fa fa-copy" style="font-size: 32px;margin-left:5px;margin-right:  45px;"></i></button>
			 </div>-->
	
			</div>
			</div>



	</div>
	<!-- /col-dm-12 -->
</div>
<!-- /row -->

<script type="text/javascript">
	// change username
	$("#submitSuggestionForm").unbind('submit').bind('submit', function() {
		var form = $(this);

		var suggestion = $("#suggestion").val();
		//var display_email = $("#display_email").val();

	

			$(".text-danger").remove();
			$('.form-group').removeClass('has-error');

			$("#submitSuggestionButton").button('loading');

			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {

					$("#submitSuggestionButton").button('reset');
					// remove text-error 
					$(".text-danger").remove();
					// remove from-group error
					$(".form-group").removeClass('has-error').removeClass('has-success');

					if(response.success == true)  {												
																
						// shows a successful message after operation
						$('.submitSuggestionMessages').html('<div class="alert alert-success">'+
	            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
	          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	          					
						
					} else {
						// shows a successful message after operation
						$('.submitSuggestionMessages').html('<div class="alert alert-warning">'+
	            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            '<strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong> '+ response.messages +
	          '</div>');

						// remove the mesages
	          $(".alert-warning").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	          					
					}
				} // /success 
			}); // /ajax
		
			
		return false;
	});
</script>

