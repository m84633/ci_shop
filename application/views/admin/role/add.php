<div style="margin-top: 50px;" class="container">
	<div class="row">
		<div class="col-6 offset-3">
			<h1>新增角色</h1>
			<?=validation_errors()?>
			<div class="card" style="width: 600px;">
			  <div class="card-body">
				<?= form_open(current_url()); ?>
				  <div class="form-group">
				    <label for="name">角色名稱</label>
				    <input type="text"  class="form-control" name="name">
				  </div>
				  <div class="row">
				  	<div class="col-4 form-group">
				  		<label for="exampleInputEmail1">商品許可</label>
				  		<?php if(isset($permissions) && $permissions): ?>
				  			<?php foreach($permissions as $permission): ?>
				  				<?php if($permission->for == "商品"): ?>
	                              <div class="checkbox">
	                                <input name='permissions[]'  type="checkbox" value="<?= $permission->id ?>"><?= $permission->name ?> 
	                              </div>
				  				<?php endif; ?>
				  			<?php endforeach; ?>	
				  		<?php endif; ?>
				  	</div>
				  	<div class="col-4 form-group">
				  		<label for="exampleInputEmail1">會員許可</label>
				  		<?php if(isset($permissions) && $permissions): ?>
				  			<?php foreach($permissions as $permission): ?>
				  				<?php if($permission->for == "會員"): ?>
	                              <div class="checkbox">
	                                <input name='permissions[]'  type="checkbox" value="<?= $permission->id ?>"><?= $permission->name ?> 
	                              </div>
				  				<?php endif; ?>
				  			<?php endforeach; ?>	
				  		<?php endif; ?>
				  	</div>
				  	<div class="col-4 form-group">
				  		<label for="exampleInputEmail1">其他</label>
				  		<?php if(isset($permissions) && $permissions): ?>
				  			<?php foreach($permissions as $permission): ?>
				  				<?php if($permission->for != "會員" && $permission->for != "商品"): ?>
	                              <div class="checkbox">
	                                <input name='permissions[]'  type="checkbox" value="<?= $permission->id ?>"><?= $permission->name ?> 
	                              </div>
				  				<?php endif; ?>
				  			<?php endforeach; ?>	
				  		<?php endif; ?>
				  	</div>
				  </div>
				  <button type="submit" class="btn btn-primary">送出</button>
				</form>
			  </div>
			</div>
		</div>
	</div>
</div>