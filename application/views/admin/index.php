<div style="margin-top: 50px" class="container">
			<h3 style="margin-left: 450px">成員管理&nbsp;&nbsp;&nbsp;<a href="<?= base_url('admin/managers/add') ?>" style="color: green" ><i class="fas fa-plus-square"></i></a></h3>
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
						<td>編號</td>
						<td>名稱</td>
						<td>角色</td>
						<td>編輯</td>
						<td>刪除</td>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($admins)): ?>
						<?php foreach($admins as $admin): ?>
						<tr>
							<td class="text-center"><?= $admin->id ?></td>
							<td><?= ellipsize($admin->name,20) ?></td>
							<td><?= $admin->roles ?></td>
							<td class="text-center"><a href="<?= base_url('admin/managers/edit').'/'.$admin->id ?>"><i class="fas fa-edit"></i></a></td>
							<td class="text-center">
								<a class="delete" onclick="event.preventDefault();if(confirm('是否要刪除?')){ document.getElementById('delete<?= $admin->id ?>').submit() }" style="cursor: pointer;color: firebrick;"><i class="fas fa-trash-alt"></i></a>
									<?= form_open(base_url('admin/managers/delete/'.$admin->id),array(
										'style'	=> "display: hidden",
										'id'	=> "delete".$admin->id
									)) ?>
									<input name="id" style="display: none" value="<?= $admin->id ?>" type="text">
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