<div style="margin-top: 50px;" class="container">
	<div class="row">
		<div class="col-6 offset-3">
			<h1>新增會員</h1>
			<?=validation_errors()?>
			<?= form_open_multipart(current_url()); ?>
			  <div class="form-group">
			    <label for="name">姓名</label>
			    <input type="text"  class="form-control" name="name">
			  </div>
			  <div class="form-group">
			    <label for="email">信箱</label>
			    <textarea name="email" class="form-control"></textarea>
			  </div>
  			  <div class="form-group">
			    <label for="password">密碼</label>
			    <input type="password" class="form-control" name="password"  >
			  </div>
			  <div class="form-group">
			    <label for="file">上傳大頭貼</label>
			    <input  id="image" type="file" class="form-control-file" name="avatar">
			  </div>
			   <div id="img_box" class="form-group">
  			  	<div class="text-center">
				  <img id="img" style="height: 200px;width: 200px"  class="rounded-circle">
				</div>
			  </div>
			  <button type="submit" class="btn btn-primary">送出</button>
			</form>
		</div>
	</div>
</div>