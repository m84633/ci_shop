<div style="margin-top: 50px;margin-bottom:50px" class="container">
	<div class="row">
		<div class="col-6 offset-3">
			<h1>新增商品</h1>
			<?=validation_errors()?>
			<?php if(isset($error)){
				echo $error;
			} ?>
			<?php if(isset($success) && $success): ?>
				<div class="alert alert-success" role="alert">
					<?= $success ?>
				</div>	
			<?php endif; ?>
			<?= form_open_multipart(current_url()); ?>
			  <div class="form-group">
			    <label for="name">商品名稱</label>
			    <input type="text" value="<?= set_value('name') ?>" class="form-control" name="name">
			  </div>
			  <div class="form-group">
			    <label for="type_id">商品類別</label>
			    <select name="type_id" class="form-control" id="">
			    	<option>請選擇...</option>
			    	<?php if(isset($types) && $types):  ?>
			    		<?php foreach($types as $type): ?>
			      			<option value="<?= $type->id ?>"><?= $type->name ?></option>
			      		<?php endforeach; ?>
			  		<?php endif; ?>
			    </select>
			  </div>
			  <div class="form-group">
			    <label for="desc">商品描述</label>
			    <textarea name="desc" class="form-control"><?= set_value('desc') ?></textarea>
			  </div>
  			  <div class="form-group">
			    <label for="price">價格</label>
			    <input type="number" class="form-control" name="price" value="<?= set_value('price') ?>" >
			  </div>
			  <div class="form-group">
			    <label for="file">上傳圖片</label>
			    <input id="image" type="file" class="form-control-file" name="image">
			  </div>
  			  <div id="img_box" class="form-group">
  			  	<div class="text-center">
				  <img id="img" style="width:250px;height: 250px" src="" class="rounded">
				</div>
			  </div>
			  <button type="submit" class="btn btn-primary">新增</button>
			</form>
		</div>
	</div>
</div>