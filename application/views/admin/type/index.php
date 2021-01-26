<div style="margin-top: 50px" class="container">
			<h3 style="margin-left: 450px">類別管理&nbsp;&nbsp;&nbsp;<a href="<?= base_url('admin/types/add') ?>" style="color: green" ><i class="fas fa-plus-square"></i></a></h3>
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
						<td>類別編號</td>
						<td>類別名稱</td>
						<td>編輯</td>
						<td>刪除</td>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($types)): ?>
						<?php foreach($types as $type): ?>
						<tr>
							<td class="text-center"><?= $type->id ?></td>
							<td><?= ellipsize($type->name,20) ?></td>
							<td class="text-center"><a href="<?= base_url('admin/types/edit').'/'.$type->id ?>"><i class="fas fa-edit"></i></a></td>
							<td class="text-center">
								<a style="cursor: pointer;color: firebrick;" class="delete" onclick="event.preventDefault();if(confirm('是否要刪除?')){ document.getElementById('delete<?= $type->id ?>').submit() }"><i class="fas fa-trash-alt"></i></a>
									<?= form_open(base_url('admin/types/delete/'.$type->id),array(
										'style'	=> "display: hidden",
										'id'	=> "delete".$type->id
									)) ?>
										<input style="display: none" type="text" name="id" value="<?= $type->id ?>">
 		                           </form>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>