$(function(){
	$('.show-modal').click(function(){
		let url = window.location.origin+'/ci_shop/orders/detail'
		let id = $(this).data('id')
		let token = $('#token').val()
		console.log(id)
		$.ajax({
			url : url,
			data:{
				'csrf_test_name':token,
				'id':id
			},
			type:'POST',
			dataType:'JSON',
			success:function(response){
				console.log(response)
				$('#token').val(response.token)
				$('#dmodal').modal('show')
				$('#d_price').text(response.detail.sum)
				$('#d_item').text(Object.keys(response.detail.items).length)
				$('#d_count').text(response.detail.total)
				let loop = 1
				$.each(response.detail.items,function(i,e){
					let html = '<tr><th scope="row">'+response.detail.items[i].item.name+'</th><td>'+response.detail.items[i].count+'</td><td>'+response.detail.items[i].item.price+'</td><td>'+response.detail.items[i].item.price*response.detail.items[i].count+'</td></tr>' 
					if(loop == 1){
						$('#d_body').html(html)
					}else{
						$('#d_body').append(html)
					}
					loop++
				})
			}
		})			
	})
})