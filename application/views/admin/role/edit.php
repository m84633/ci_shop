<div style="margin-top: 50px;" class="container">
	<div class="row">
		<div class="col-6 offset-3">
			<h1>修改角色</h1>
			<?=validation_errors()?>
			<?php if(isset($success) && $success): ?>
				<div class="alert alert-success" role="alert">
					<?= $success ?>
				</div>
			<?php endif; ?>	
			<div class="card" style="width: 600px;">
			  <div class="card-body">
				<?= form_open(current_url()); ?>
				  <div class="form-group">
				    <label for="name">角色名稱</label>
				    <input value="<?= $role->name ?>" type="text"  class="form-control" name="name">
				  </div>
				  <div class="row">
				  	<div class="col-4 form-group">
				  		<label for="exampleInputEmail1">商品許可</label>
				  		<?php if(isset($permissions) && $permissions): ?>
				  			<?php foreach($permissions as $permission): ?>
				  				<?php if($permission->for == "商品"): ?>
	                              <div class="checkbox">
	                                <input name='permissions[]'  type="checkbox" value="<?= $permission->id ?>" 
	                                <?php 
	                                	foreach($has_permissions as $has){
	                                		if($has->permission_id == $permission->id){
	                                			echo 'checked';
	                                		} 
	                                	}
	                                ?> >
	                                <?= $permission->name ?> 
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
	                                <input name='permissions[]'  type="checkbox" value="<?= $permission->id ?>"
	                                <?php  
	                                	foreach ($has_permissions as $has) {
                            		   		if($has->permission_id == $permission->id){
	                                			echo 'checked';
	                                		} 
	                                	}
	                                ?>
	                                ><?= $permission->name ?> 
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
	                                <input name='permissions[]'  type="checkbox" value="<?= $permission->id ?>"
	                                	<?php
	                                		foreach($has_permissions as $has){
                            		   			if($has->permission_id == $permission->id){
	                                				echo 'checked';
	                                			} 
	                                		}
	                                	?>
	                                ><?= $permission->name ?> 
	                              </div>
				  				<?php endif; ?>
				  			<?php endforeach; ?>	
				  		<?php endif; ?>
				  	</div>
				  </div>
				  <button type="submit" class="btn btn-primary">送出</button>
	  			  <a href="<?= base_url('admin/roles') ?>" type="submit" class="btn btn-secondary">上一頁</a>
				</form>
			  </div>
			</div>
		</div>
	</div>
</div>