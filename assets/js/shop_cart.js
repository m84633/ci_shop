$(function(){
	$('.fa-plus').click(function(e){
		// let url = $(this).data('href')
		let url = window.location.origin+'/ci_shop/products/add'
		let id = $(this).data('id')
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
					console.log(response)
					$('#token').val(response.ajax)
					$('.total').text(response.total)
					$('#'+id).val(function(i,val){
						return +val+1
					})
					$('#sum').text(function(i){
						return response.sum
					})
					$('#summary'+id).text(function(i,text){
						return +text+(response.message[id]['item']['price'])*1
					})
					$('#temporary').text(function(i,text){
						return response.sum
					})
				}
		})
	})
	$('.fa-minus').click(function(){
		let url = window.location.origin+'/ci_shop/products/minus'
		let id = $(this).data('id')
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
					console.log(response)
					console.log(response.sum)
					$('#token').val(response.ajax)
					$('.total').text(response.total)
					$('#'+id).val(function(i,val){
						return response.message[id]['count']
					})
					$('#sum').text(function(i){
						return response.sum
					})
					$('#summary'+id).text(function(i,text){
						return response.message[id]['item']['price']*response.message[id]['count']
					})
					$('#temporary').text(function(i,text){
						return response.sum
					})
				}
		})
	})
	$('.unset').click(function(){
		let url = window.location.origin+'/ci_shop/products/unset'
		let id = $(this).data('id')
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
				console.log(response)
				console.log(response.sum)
				$('#token').val(response.ajax)
				$('.total').text(response.total)
				if($('#total').text() == 0){
					$('#total').hide()
					$('#total_item').hide()
					let index = window.location.origin+'/ci_shop'
					$("section").append('<h3 style="margin-top: 100px">目前購物車無任何商品 <br><a style="margin-top: 10px" class="btn btn-info btn-md" href="'+index+'">前往商店</a></h3>')
				}

				$('#sum').text(function(i){
					return response.sum
				})
				$('#temporary').text(function(i,text){
					return response.sum
				})
				$('#item'+id).hide()
			}

		})
	})
})