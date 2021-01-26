<div style="margin-top: 50px;margin-bottom: 50px" class="container">
	<div class="row">
		<div class="col-6 offset-3">
			<h1>修改商品</h1>
			<?=validation_errors()?>
			<?php if(isset($error)): ?>
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			<?php endif; ?>
			<?php if(isset($success)): ?>
				<div class="alert alert-success" role="alert">
					<?= $success ?>
				</div>
			<?php endif; ?>	
			<?= form_open_multipart(current_url()); ?>
			  <div class="form-group">
			    <label for="name">商品名稱</label>
			    <input type="text" value="<?= $product->name ?>" class="form-control" name="name">
			  </div>
			  <div class="form-group">
			    <label for="desc">商品描述</label>
			    <textarea style="height: 100px" name="desc" class="form-control"><?= $product->desc ?></textarea>
			  </div>
  			  <div class="form-group">
			    <label for="price">價格</label>
			    <input type="number" class="form-control" name="price" value="<?= $product->price ?>" >
			  </div>
  			  <div class="form-group">
  			  	<div class="text-center">
				  <img id="img" style="height:250px;height: 250px" src="<?= base_url('uploads').'/'.$product->image ?>" class="rounded">
				</div>
			  </div>
			  <div class="form-group">
			    <label for="file">上傳圖片</label>
			    <input id="image" type="file" class="form-control-file" name="image">
			  </div>
			  <button type="submit" class="btn btn-primary">送出</button>
			</form>
		</div>
	</div>
</div>