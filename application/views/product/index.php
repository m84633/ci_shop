<div style="margin-top: 50px" class="container">
	<div class="row">
		<div class="col-3">
			<div class="list-group">
			 	<a href="<?= base_url() ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= isset($type_id) ? '':'active' ?>">
			  		所有書籍
			  		<span class="badge badge-secondary badge-pill"><?= $total_counts ?></span>
				</a>
			 <?php foreach($types as $type): ?>
				<a href="<?= base_url('types/'.$type->id) ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= isset($type_id) ? (($type_id == $type->id) ? 'active' : '') : ''  ?>">
			  		<?= $type->name ?>
			  		<span class="badge badge-secondary badge-pill">
			  		<?php
			  			foreach($type_counts as $type_count){
			  				echo ($type_count->type_id == $type->id) ? $type_count->total : '' ;
			  			} 
			  		?>
			  		</span>
				</a>
			<?php endforeach; ?>
			</div>
		</div>
		<div class="col-9">
			<div class="row">
				<?php if(count($products) == 0): ?>
					<h3 style="margin-left: 50px">查無相關商品</h3>
				<?php endif; ?>
				<?php foreach($products as $product): ?>
					<div class="col-4">
						<div class="card" style="width: 16rem;">
						  <img style="height: 250px" src="<?= base_url('uploads/'.$product->image) ?>" class="card-img-top">
						  <div class="card-body">
						  	<div style="height: 80px">
						    	<h5 class="card-title"><b><?= ellipsize($product->name,20) ?></b></h5>
						  	</div>
						    <p class="card-text">$NT&nbsp<?= $product->price ?></p>
						    <a data-id="<?= $product->id ?>" style="cursor: pointer" class="btn btn-info add-cart">加入購物車</a>
						  </div>
						</div>
					</div>
				<?php endforeach; ?>
						    <input id="token" style="display: none" value="<?=$this->security->get_csrf_hash();?>" type="text">
			</div>
		</div>
	</div>
	<div style="margin-top: 20px" class="row justify-content-center">
		<?= $pageination ?>
	</div>
</div>
