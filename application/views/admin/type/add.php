<div style="margin-top: 50px;" class="container">
	<div class="row">
		<div class="col-6 offset-3">
			<h1>新增類型</h1>
			<?=validation_errors()?>
			<?php if(isset($success) && $success): ?>
				<div class="alert alert-success" role="alert">
					<?= $success ?>
				</div>
			<?php endif; ?>	
			<?php if(isset($error) && $error): ?>
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			<?php endif; ?>
			<?= form_open(current_url()); ?>
			  <div class="form-group">
			    <label for="name">類型名稱</label>
			    <input type="text" value="<?= set_value('name') ?>" class="form-control" name="name">
			  </div>
			<button type="submit" class="btn btn-primary">新增</button>
			<a href="<?= base_url('admin/types') ?>" class="btn btn-secondary btn-md ml-2">上一頁</a>
			</form>
		</div>
	</div>
</div>