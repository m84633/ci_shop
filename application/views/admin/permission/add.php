<div style="margin-top: 50px;" class="container">
	<div class="row">
		<div class="col-6 offset-3">
			<h1>新增權限</h1>
			<?=validation_errors()?>
			<?= form_open(current_url()); ?>
			  <div class="form-group">
			    <label for="name">權限名稱</label>
			    <input type="text"  class="form-control" name="name">
			  </div>
  			  <div class="form-group">
			    <label for="for">權限類型</label>
			    <input type="text"  class="form-control" name="for">
			  </div>
			  <button type="submit" class="btn btn-primary">送出</button>
			</form>
		</div>
	</div>
</div>