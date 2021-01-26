<div style="margin-top: 50px;" class="container">
	<div class="row">
		<div class="col-6 offset-3">
			<h1>管理員新增</h1>
			<?=validation_errors()?>
			<?= form_open(current_url()); ?>
			  <div class="form-group">
			    <label for="email">帳號</label>
			    <input  name="username" value="<?= set_value('username') ?>"  class="form-control">
			  </div>
			  <div class="form-group">
			    <label for="name">姓名</label>
			    <input type="text" value="<?= set_value('name') ?>" class="form-control" name="name">
			  </div>
  			  <div class="form-group">
			    <label for="password">密碼</label>
			    <input type="password" value="" class="form-control" name="password" value="" >
			  </div>
			  <div class="form-group">
			    <label for="role">角色</label>
			    <select name="roles[]" multiple class="form-control">
				    <?php if(isset($roles) && $roles): ?>
				    	<?php foreach($roles as $role): ?>
				      		<option value="<?= $role->id ?>" ><?= $role->name ?></option>
				      	<?php endforeach; ?>
				     <?php endif; ?>
			    </select>
			  </div>
			  <button type="submit" class="btn btn-primary">送出</button>
			  <a href="<?= base_url('admin/managers') ?>" type="submit" class="btn btn-secondary">上一頁</a>
			</form>
		</div>
	</div>
</div>