<div style="margin-top: 50px" class="container">
			<h3 style="margin-left: 450px">商品管理&nbsp;&nbsp;&nbsp;
				<?php if(in_array('1',$permissions)): ?>
					<a href="<?= base_url('admin/products/add') ?>" style="color: green" >
						<i class="fas fa-plus-square"></i>
					</a>
				<?php endif; ?>
			</h3>
			<?php if($this->session->flashdata('delete_error')): ?>
				<div class="alert alert-danger" role="alert">
					<?= $this->session->flashdata('delete_error') ?>
				</div>
			<?php endif ?>
	<div class="row">
		<div class="card">
		<div class="card-body">
			<table style="width: 1000px"  id="datatable" class="table table-bordered table-hover">
				<thead>
					<tr>
						<td>商品編號</td>
						<td>商品名稱</td>
						<td>價格</td>
						<td>商品類型</td>
						<?php if(in_array('2',$permissions)): ?>
							<td>編輯</td>
						<?php endif; ?>
						<?php if(in_array('3',$permissions)): ?>
						<td>刪除</td>
						<?php endif; ?>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($products)): ?>
						<?php foreach($products as $product): ?>
						<tr>
							<td class="text-center"><?= $product->id ?></td>
							<td><?= ellipsize($product->name,20) ?></td>
							<td><?= $product->price ?></td>
							<td><?php
								if(isset($types)){
									foreach($types as $type){
										if($product->type_id == $type->id){
											echo $type->name;
										}
									}
								}
							 ?></td>
							<?php if(in_array('2',$permissions)): ?>
								<td class="text-center"><a href="<?= base_url('admin/products/edit').'/'.$product->id ?>"><i class="fas fa-edit"></i></a></td>
							<?php endif; ?>
							<?php if(in_array('3',$permissions)): ?>
							<td class="text-center">
								<a class="delete" onclick="event.preventDefault();if(confirm('是否要刪除?')){ document.getElementById('delete<?= $product->id ?>').submit() }" style="cursor: pointer;color: firebrick;"><i class="fas fa-trash-alt"></i></a>
									<?= form_open(base_url('admin/products/delete/'.$product->id),array(
										'style'	=> "display: hidden",
										'id'	=> "delete".$product->id
									)) ?>
										<input style="display: none" type="text" name="id" value="<?= $product->id ?>">
 		                           </form>
							</td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>