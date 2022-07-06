var manageProductTable;

$(document).ready(function() {

	
	// top nav bar 
	$('#navProduct').addClass('active');
	// manage product data table
	manageProductTable = $('#manageProductTable').DataTable({
		'ajax': 'php_action/fetchProduct.php',
		'scrollX': true,
		'order': []
	});

	// add product modal btn clicked
	$("#addProductModalBtn").unbind('click').bind('click', function() {
		// // product form reset
		$("#submitProductForm")[0].reset();		

		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		$("#productImage").fileinput({
	      overwriteInitial: true,
		    maxFileSize: 2500,
		    showClose: false,
		    showCaption: false,
		    browseLabel: '',
		    removeLabel: '',
		    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
		    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
		    removeTitle: 'Cancel or reset changes',
		    elErrorContainer: '#kv-avatar-errors-1',
		    msgErrorClass: 'alert alert-block alert-danger',
		    defaultPreviewContent: '<img src="assests/images/photo_default.png" alt="Profile Image" style="width:100%;">',
		    layoutTemplates: {main2: '{preview} {remove} {browse}'},								    
	  		allowedFileTypes: ['image']
			});   

		// submit product form
		$("#submitProductForm").unbind('submit').bind('submit', function() {

			// form validation
			//var productImage = $("#productImage").val();
			var productName = $("#productName").val();
			var shortDescription = $("#shortDescription").val();
			var cost = $("#cost").val();
			var brandName = $("#brandName").val();
			var categoryName = $("#categoryName").val();
			

	
			/*if(productImage == "") {
				$("#productImage").closest('.center-block').after('<p class="text-danger">Product Image field is required</p>');
				$('#productImage').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#productImage").find('.text-danger').remove();
				// success out for form 
				$("#productImage").closest('.form-group').addClass('has-success');	  	
			}	*/

			if(productName == "") {
				$("#productName").after('<p class="text-danger">Product Name field is required</p>');
				$('#productName').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#productName").find('.text-danger').remove();
				// success out for form 
				$("#productName").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(shortDescription == "") {
				$("#shortDescription").after('<p class="text-danger">Short Description field is required</p>');
				$('#shortDescription').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#shortDescription").find('.text-danger').remove();
				// success out for form 
				$("#shortDescription").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(cost == "") {
				$("#cost").after('<p class="text-danger">Cost field is required</p>');
				$('#cost').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#cost").find('.text-danger').remove();
				// success out for form 
				$("#cost").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(brandName == "") {
				$("#brandName").after('<p class="text-danger">Brand Name field is required</p>');
				$('#brandName').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#brandName").find('.text-danger').remove();
				// success out for form 
				$("#brandName").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(categoryName == "") {
				$("#categoryName").after('<p class="text-danger">Category Name field is required</p>');
				$('#categoryName').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#categoryName").find('.text-danger').remove();
				// success out for form 
				$("#categoryName").closest('.form-group').addClass('has-success');	  	
			}	// /else



			if(productName && shortDescription && cost && brandName && categoryName) {
				//fetch modal content before anything is changed.
				var previousAddProductModalContent = addProductModal.innerHTML;
				// submit loading button
				$("#createProductBtn").button('loading');

				var form = $(this);
				var formData = new FormData(this);

				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: formData,
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					success:function(response) {

						if(response.success == true) {
							// submit loading button
							$("#createProductBtn").button('reset');
							
							$("#submitProductForm")[0].reset();

							$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																	
							// shows a successful message after operation
							$('#add-product-messages').html('<div class="alert alert-success">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          '</div>');

							// remove the mesages
		          $(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert

		          // reload the manage student table
							manageProductTable.ajax.reload(null, true);

							// remove text-error 
							$(".text-danger").remove();
							// remove from-group error
							$(".form-group").removeClass('has-error').removeClass('has-success');


							$('#addProductModal').html('  <div class="modal-dialog">'+
    '<div class="modal-content">'+

    	'<form action="php_action/uploadImageFile.php" method="POST" id="addProductImageForm" class="form-horizontal" enctype="multipart/form-data">'+
	      '<div class="modal-header">'+
	        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
	        '<h4 class="modal-title"><i class="fa fa-plus"></i> Upload Product Image</h4>'+
	      '</div>'+



	      '<div class="modal-body" style="max-height:450px; overflow:auto;">'+

	      	'<div id="add-productPhoto-messages"></div>'+

				/*'<div class="form-group">'+
			        	'<label for="ProductImage" class="col-sm-3 control-label">Product Image: </label>'+
			        	'<label class="col-sm-1 control-label">: </label>'+
						    '<div class="col-sm-8">'+							    				   
						      '<img src="" id="getProductImage" class="thumbnail" style="width:250px; height:250px;" />'+
						    '</div>'+
			        '</div> <!-- /form-group-->'+*/

			        '<div class="form-group">'+
			        	'<label for="addProductImage" class="col-sm-3 control-label">Select image to upload: </label>'+
			        	'<label class="col-sm-1 control-label">: </label>'+
						    '<div class="col-sm-8">'+							    				   
						      '<input type="file" style="display: inline-block;" name="addProductImage" id="addProductImage">'+  
						    '</div>'+
			        '</div>'+ 		        	         	       
	            	        
	      '</div>'+
	      '<input type="hidden" name="source" id="source" value="add" />'+
	      '<input type="hidden" name="productId" id="productId" value="'+response.id+'" />'+
	      '<div class="modal-footer">'+
	        '<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>'+
	        
	        '<button type="submit" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>'+
	      '</div> <!-- /modal-footer -->'+	      
     	'</form> <!-- /.form -->'+	     
    '</div> <!-- /modal-content -->'+    
  '</div> <!-- /modal-dailog -->');

							$('#addProductModal').on('hidden.bs.modal', function () {
								addProductModal.innerHTML = previousAddProductModalContent;
							})

							// update the product image				
				$("#addProductImageForm").unbind('submit').bind('submit', function() {					
					// form validation
					var productImage = $("#addProductImage").val();					
					
					if(productImage == "") {
						$("#addProductImage").closest('.center-block').after('<p class="text-danger">Product Image field is required</p>');
						$('#addProductImage').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#addProductImage").find('.text-danger').remove();
						// success out for form 
						$("#addProductImage").closest('.form-group').addClass('has-success');	  	
					}	// /else


					if(productImage) {
						// submit loading button
						$("#addProductImageBtn").button('loading');

						var form = $(this);
						var formData = new FormData(this);

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: formData,
							dataType: 'json',
							cache: false,
							contentType: false,
							processData: false,
							success:function(response) {
								
								if(response.success == true) {
									// submit loading button
									$("#addProductImageBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																			
									// shows a successful message after operation
									$('#add-productPhoto-messages').html('<div class="alert alert-success">'+
				            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
				          '</div>');

									// remove the mesages
				          $(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

				          // reload the manage student table
									manageProductTable.ajax.reload(null, true);

									$(".fileinput-remove-button").click();

									$.ajax({
										url: 'php_action/fetchProductImageUrl.php?i='+productId,
										type: 'post',
										success:function(response) {
										$("#getProductImage").attr('src', response);		
										}
									});																		

									// remove text-error 
									$(".text-danger").remove();
									// remove from-group error
									$(".form-group").removeClass('has-error').removeClass('has-success');

									
									$('#addProductModal').modal('hide');

								} // /if response.success
								else if(response.success==false){

									$("#addProductImageBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																			
									// shows a successful message after operation
									$('#add-productPhoto-messages').html('<div class="alert alert-danger">'+
				            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
				          '</div>');

							// remove the messages
				          $(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

								}
								
							} // /success function
						}); // /ajax function
					}	 // /if validation is ok 					

					return false;
				}); // /update the product image


						} // /if response.success
						
					} // /success function
				}); // /ajax function
			}	 // /if validation is ok 



			return false;
		}); // /submit product form

	}); // /add product modal btn clicked



				
	

	// remove product 	

}); // document.ready fucntion

function editProduct(productId = null) {

	if(productId) {
		$("#productId").remove();		
		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		// modal spinner
		$('.div-loading').removeClass('div-hide');
		// modal div
		$('.div-result').addClass('div-hide');

		$.ajax({
			url: 'php_action/fetchSelectedProduct.php',
			type: 'post',
			data: {productId: productId},
			dataType: 'json',
			success:function(response) {		
			// alert(response.product_image);
				// modal spinner
				$('.div-loading').addClass('div-hide');
				// modal div
				$('.div-result').removeClass('div-hide');

				image_src=response.image;

				if(image_src==''){
					image_src = 'http://promote.javy.co.ke/assests/images/product-images/no-image-uploaded.jpg';
				}else{
					image_src = image_src.replace('..', 'http://promote.javy.co.ke');
				}

								

				$("#getProductImage").attr('src', image_src);

				$("#editProductImage").fileinput({		      
				});  

				// $("#editProductImage").fileinput({
		  //     overwriteInitial: true,
			 //    maxFileSize: 2500,
			 //    showClose: false,
			 //    showCaption: false,
			 //    browseLabel: '',
			 //    removeLabel: '',
			 //    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			 //    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			 //    removeTitle: 'Cancel or reset changes',
			 //    elErrorContainer: '#kv-avatar-errors-1',
			 //    msgErrorClass: 'alert alert-block alert-danger',
			 //    defaultPreviewContent: '<img src="stock/'+response.product_image+'" alt="Profile Image" style="width:100%;">',
			 //    layoutTemplates: {main2: '{preview} {remove} {browse}'},								    
		  // 		allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
				// });  

				// product id 
				$(".editProductFooter").append('<input type="hidden" name="productId" id="productId" value="'+response.id+'" />');				
				$(".editProductPhotoFooter").append('<input type="hidden" name="productId" id="productId" value="'+response.id+'" />');				
				
				// product name

				var user_id=$("#user_id").val();

				//alert(user_id+'='+response.supplier_id)

				var SuppliersCost=0;
				var SuppliersProfit=0;
				var SuppliersPrice=0;

				if(user_id!=response.supplier_id){




					$("#editProductImage").attr('readonly', 'readonly');
					$('#editProductImageInput').hide();
					$("#editProductName").attr('readonly', 'readonly');
					$("#editBrandName").attr('readonly', 'readonly');
					$("#editCategoryName").attr('readonly', 'readonly');
					$("#editProductStatus").attr('readonly', 'readonly');
					$("#editDescription").attr('readonly', 'readonly');



					$.ajax({
			url: 'php_action/fetchSelectedProductFromMoreSuppliers.php',
			type: 'post',
			data: {productId: productId},
			dataType: 'json',
			success:function(response2) {

				var cost_displayed=response2.cost;
				var profit_displayed=response2.profit;
				var price_displayed=response2.price;

				if(cost_displayed==0){
					cost_displayed=response.cost;
				}

				if(profit_displayed==0){
					profit_displayed=response.profit;
				}

				if(price_displayed==0){
					price_displayed=response.price;
				}

				$("#editCost").val(cost_displayed);
				// commission
				$("#editCommission").val(profit_displayed);
				// rate
				$("#editRate").val(price_displayed);
				//alert(response2.price+' '+response2.profit+' '+response2.cost);
				//alert(response.price+' '+response.profit+' '+response.cost);

				}
			});

				}else{
					$("#editProductImage").removeAttr('readonly');;
					$('#editProductImageInput').show();
					$("#editProductName").removeAttr('readonly');
					$("#editBrandName").removeAttr('readonly');
					$("#editCategoryName").removeAttr('readonly');
					$("#editProductStatus").removeAttr('readonly');
					$("#editDescription").removeAttr('readonly');

				$("#editCost").val(response.cost);
				// commission
				$("#editCommission").val(response.profit);
				// rate
				$("#editRate").val(response.price);

				}

				


				if($("#editCost").val()==0){
					$("#editCost").val(response.cost);
				}
				if($("#editCommission").val()==0){
					$("#editCommission").val(response.profit);
				}
				if($("#editRate").val()==0){
					$("#editRate").val(response.price);
				}


				$("#brandHolder").val(response.brand);

				$("#editProductName").val(response.name);
				// quantity

				// category name
				var text = response.highlights;
    			text = text.replace(/<br\s*\/?>/gi,' ');

    			console.log(text);
				$("#editDescription").val(text);

				$("#editCategoryName").val(response.category);
				// brand name
				$("#editBrandName").val(response.brand);

				if(response.approval==2){
					$('#editApprovalStatus').val('Approved on main site & Javy')
				}else if(response.approval==1){
					$('#editApprovalStatus').val('Approved on main site')
				}else if (response.approval==0){
					$('#editApprovalStatus').val('Awaiting Approval on main site')
				}
				

				
				//if response status == 2, requested products, disable availability
				if(response.status==2){
					$('#editProductStatus').append('<option value="2">Requested</option>');
					$("#editProductStatusSection").hide();
				}else{
					$("#editProductStatus option[value='2']").remove();
					$("#editProductStatusSection").show();
				}
				// status
				$("#editProductStatus").val(response.status);




				// update the product data function
				$("#editProductForm").unbind('submit').bind('submit', function() {

					// form validation
					var productImage = $("#editProductImage").val();
					var productName = $("#editProductName").val();
					//var quantity = $("#editQuantity").val();
					var cost = $("#editCost").val();
					var rate = $("#editRate").val();
					var brandName = $("#editBrandName").val();
					var categoryName = $("#editCategoryName").val();
					var productStatus = $("#editProductStatus").val();
					var description = $("#editDescription").val();
								

					if(productName == "") {
						$("#editProductName").after('<p class="text-danger">Product Name field is required</p>');
						$('#editProductName').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editProductName").find('.text-danger').remove();
						// success out for form 
						$("#editProductName").closest('.form-group').addClass('has-success');	  	
					}	// /else

					/*QUEANTITY VALIDATION NOT REQUIRED
					if(quantity == "") {
						$("#editQuantity").after('<p class="text-danger">Quantity field is required</p>');
						$('#editQuantity').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editQuantity").find('.text-danger').remove();
						// success out for form 
						$("#editQuantity").closest('.form-group').addClass('has-success');	  	
					}	// /else

					*/

					if(cost == "") {
						$("#editCost").after('<p class="text-danger">Cost field is required</p>');
						$('#editCost').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editCost").find('.text-danger').remove();
						// success out for form 
						$("#editCost").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(rate == "") {
						$("#editRate").after('<p class="text-danger">Rate field is required</p>');
						$('#editRate').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editRate").find('.text-danger').remove();
						// success out for form 
						$("#editRate").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(brandName == "") {
						$("#editBrandName").after('<p class="text-danger">Brand Name field is required</p>');
						$('#editBrandName').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editBrandName").find('.text-danger').remove();
						// success out for form 
						$("#editBrandName").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(categoryName == "") {
						$("#editCategoryName").after('<p class="text-danger">Category Name field is required</p>');
						$('#editCategoryName').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editCategoryName").find('.text-danger').remove();
						// success out for form 
						$("#editCategoryName").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(productStatus == "") {
						$("#editProductStatus").after('<p class="text-danger">Product Status field is required</p>');
						$('#editProductStatus').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editProductStatus").find('.text-danger').remove();
						// success out for form 
						$("#editProductStatus").closest('.form-group').addClass('has-success');	  	
					}	// /else					

					if(productName && cost && rate && brandName && categoryName && productStatus) {
						// submit loading button
						$("#editProductBtn").button('loading');

						var form = $(this);
						var formData = new FormData(this);

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: formData,
							dataType: 'json',
							cache: false,
							contentType: false,
							processData: false,
							success:function(response) {
								console.log(response);
								if(response.success == true) {
									// submit loading button
									$("#editProductBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																			
									// shows a successful message after operation
									$('#edit-product-messages').html('<div class="alert alert-success">'+
				            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
				          '</div>');

									// remove the mesages
				          $(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

				          // reload the manage student table
									manageProductTable.ajax.reload(null, true);

									// remove text-error 
									$(".text-danger").remove();
									// remove from-group error
									$(".form-group").removeClass('has-error').removeClass('has-success');

								} // /if response.success

								else if(response.success == false) {
									// submit loading button
									$("#editProductBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																			
									// shows a successful message after operation
									$('#edit-product-messages').html('<div class="alert alert-danger">'+
				            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
				          '</div>');

									// remove the mesages
				          $(".alert-danger").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

				          

									// remove text-error 
									$(".text-danger").remove();
									// remove from-group error
									$(".form-group").removeClass('has-error').removeClass('has-success');

								} // /if response.success is false
								
							} // /success function
						}); // /ajax function
					}	 // /if validation is ok 					

					return false;
				}); // update the product data function

				// update the product image				
				$("#updateProductImageForm").unbind('submit').bind('submit', function() {					
					// form validation
					var productImage = $("#editProductImage").val();					
					
					if(productImage == "") {
						$("#editProductImage").closest('.center-block').after('<p class="text-danger">Product Image field is required</p>');
						$('#editProductImage').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editProductImage").find('.text-danger').remove();
						// success out for form 
						$("#editProductImage").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(productImage) {
						// submit loading button
						$("#editProductImageBtn").button('loading');

						var form = $(this);
						var formData = new FormData(this);

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: formData,
							dataType: 'json',
							cache: false,
							contentType: false,
							processData: false,
							success:function(response) {
								
								if(response.success == true) {
									// submit loading button
									$("#editProductImageBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																			
									// shows a successful message after operation
									$('#edit-productPhoto-messages').html('<div class="alert alert-success">'+
				            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
				          '</div>');

									// remove the mesages
				          $(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

				          // reload the manage student table
									manageProductTable.ajax.reload(null, true);

									$(".fileinput-remove-button").click();

									$.ajax({
										url: 'php_action/fetchProductImageUrl.php?i='+productId,
										type: 'post',
										success:function(response) {
										$("#getProductImage").attr('src', response);		
										}
									});																		

									// remove text-error 
									$(".text-danger").remove();
									// remove from-group error
									$(".form-group").removeClass('has-error').removeClass('has-success');

									
									$('#editProductModal').modal('hide');

								} // /if response.success
								else if(response.success==false){

									$("#editProductImageBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																			
									// shows a successful message after operation
									$('#edit-productPhoto-messages').html('<div class="alert alert-danger">'+
				            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
				          '</div>');

							// remove the messages
				          $(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

								}
								
							} // /success function
						}); // /ajax function
					}	 // /if validation is ok 					

					return false;
				}); // /update the product image

			} // /success function
		}); // /ajax to fetch product image

				
	} else {
		alert('error please refresh the page');
	}
} // /edit product function

// remove product 
function removeProduct(productId = null) {
	if(productId) {
		// remove product button clicked
		$("#removeProductBtn").unbind('click').bind('click', function() {
			// loading remove button
			$("#removeProductBtn").button('loading');
			$.ajax({
				url: 'php_action/removeProduct.php',
				type: 'post',
				data: {productId: productId},
				dataType: 'json',
				success:function(response) {
					// loading remove button
					$("#removeProductBtn").button('reset');
					if(response.success == true) {
						// remove product modal
						$("#removeProductModal").modal('hide');

						// update the product table
						manageProductTable.ajax.reload(null, false);

						// remove success messages
						$(".remove-messages").html('<div class="alert alert-success">'+
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

						// remove success messages
						$(".removeProductMessages").html('<div class="alert alert-success">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert

					} // /error
				} // /success function
			}); // /ajax fucntion to remove the product
			return false;
		}); // /remove product btn clicked
	} // /if productid
} // /remove product function

function clearForm(oForm) {
	// var frm_elements = oForm.elements;									
	// console.log(frm_elements);
	// 	for(i=0;i<frm_elements.length;i++) {
	// 		field_type = frm_elements[i].type.toLowerCase();									
	// 		switch (field_type) {
	// 	    case "text":
	// 	    case "password":
	// 	    case "textarea":
	// 	    case "hidden":
	// 	    case "select-one":	    
	// 	      frm_elements[i].value = "";
	// 	      break;
	// 	    case "radio":
	// 	    case "checkbox":	    
	// 	      if (frm_elements[i].checked)
	// 	      {
	// 	          frm_elements[i].checked = false;
	// 	      }
	// 	      break;
	// 	    case "file": 
	// 	    	if(frm_elements[i].options) {
	// 	    		frm_elements[i].options= false;
	// 	    	}
	// 	    default:
	// 	        break;
	//     } // /switch
	// 	} // for
}