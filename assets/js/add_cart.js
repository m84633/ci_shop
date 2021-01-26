	$(function(){
	$('.add-cart').click(function(e){
		let id = $(this).data('id')
		let url = window.location.origin+'/ci_shop/products/add'
		$.ajax({
				url : url,
				data : {
					'csrf_test_name':$('#token').val(),
					'id':id
				},
				type : "POST",
				dataType : 'JSON',
				error : function(error){
					console.log(error)
				},
				success : function(response){
					$.toast({ 
							  text : "<span style='font-size: 20px'><strong><i class='fas fa-check'></i>  成功加入購物車</span></strong>", 
							  showHideTransition : 'fade',  // It can be plain, fade or slide
							  bgColor : '#E9967A',              // Background color for toast
							  textColor : '#',            // text color
							  allowToastClose : true,       // Show the close button or not
							  hideAfter : 3000,              // `false` to make it sticky or time in miliseconds to hide after
							  stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
							  textAlign : 'left',            // Alignment of text i.e. left, right, center
							  position : { top: '60px' , bottom: '100px', left: '1200px', right: '0px' }       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
							})
					console.log(response)
					$('#token').val(response.ajax)
					$('#total').attr("style","display:inline")
					$('#total').text(response.total)
				}
			})
	})
})