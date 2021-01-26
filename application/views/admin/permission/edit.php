<div style="margin-top: 50px;" class="container">
	<div class="row">
		<div class="col-6 offset-3">
			<h1>修改權限</h1>
			<?=validation_errors()?>
			<?php if(isset($success) && $success): ?>
				<div class="alert alert-success" role="alert">
					<?= $success ?>
				</div>
			<?php endif; ?>	

			<?= form_open_multipart(current_url()); ?>
			  <div class="form-group">
			    <label for="name">權限名稱</label>
			    <input type="text" value="<?= $permission->name ?>" class="form-control" name="name">
			  </div>
  			  <div class="form-group">
			    <label for="for">權限名稱</label>
			    <input type="text" value="<?= $permission->for ?>" class="form-control" name="for">
			  </div>
			  <button type="submit" class="btn btn-primary">送出</button>
			  <a href="<?= base_url('admin/permissions') ?>" type="submit" class="btn btn-secondary">上一頁</a>
			</form>
		</div>
	</div>
</div>