$(function(){
	$("#img_box").hide();
	$("#image").on("change",function(){
		let file = $("#image")[0].files[0]
		let reader = new FileReader
		reader.onload = function(e){
			$("#img").attr('src',e.target.result);
		}
		reader.readAsDataURL(file)
		$("#img_box").show();	
	})


})