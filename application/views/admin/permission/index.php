<div style="margin-top: 50px" class="container">
			<h3 style="margin-left: 450px">權限管理&nbsp;&nbsp;&nbsp;<a href="<?= base_url('admin/permissions/add') ?>" style="color: green" ><i class="fas fa-plus-square"></i></a></h3>
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
						<td>權限編號</td>
						<td>權限名稱</td>
						<td>類型</td>
						<td>編輯</td>
						<td>刪除</td>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($permissions)): ?>
						<?php foreach($permissions as $permission): ?>
						<tr>
							<td class="text-center"><?= $permission->id ?></td>
							<td><?= ellipsize($permission->name,20) ?></td>
							<td><?= $permission->for ?></td>
							<td class="text-center"><a href="<?= base_url('admin/permissions/edit').'/'.$permission->id ?>"><i class="fas fa-edit"></i></a></td>
							<td class="text-center">
								<a class="delete" onclick="event.preventDefault();if(confirm('是否要刪除?')){ document.getElementById('delete<?= $permission->id ?>').submit() }" style="cursor: pointer;color: firebrick;"><i class="fas fa-trash-alt"></i></a>
									<?= form_open(base_url('admin/permissions/delete/'.$permission->id),array(
										'style'	=> "display: hidden",
										'id'	=> "delete".$permission->id
									)) ?>
									<input style="display: none" type="text" name="id" value="<?= $permission->id ?>">
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