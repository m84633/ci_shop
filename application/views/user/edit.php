<div style="margin-top: 50px;margin-bottom: 50px" class="container">
	<div class="row">
		<div class="col-6 offset-3">
			<h1>會員資料修改</h1>
			<?=validation_errors()?>
			<?php if($this->session->flashdata('success')): ?>
				<div class="alert alert-success" role="alert">
					<?= $this->session->flashdata('success') ?> 
				</div>
			<?php endif; ?>	

			<?= form_open_multipart(current_url()); ?>
			  <div class="form-group">
			    <label for="name">姓名</label>
			    <input type="text" value="<?= $user_edit->name ?>" class="form-control" name="name">
			  </div>
			  <div class="form-group">
			    <label for="email">信箱</label>
			    <textarea readonly name="email" class="form-control"><?= $user_edit->email ?></textarea>
			  </div>
  			  <div class="form-group">
			    <label for="password">密碼</label>
			    <input type="number" class="form-control" name="password" value="" >
			  </div>
			  <div id="img_box" class="form-group">
  			  	<div class="text-center">
				  <img id="img" style="height: 200px;width: 200px" src="<?= base_url('uploads').'/'.$user_edit->id.'/'.$user_edit->avatar ?>" class="rounded-circle">
				</div>
			  </div>
			  <div class="form-group">
			    <label for="file">上傳大頭貼</label>
			    <input id="image" type="file" class="form-control-file" name="avatar">
			  </div>
			  <button type="submit" class="btn btn-primary">送出</button>
			</form>
		</div>
	</div>
</div>