<div style="margin-top: 50px" class="container">
			<h3 style="margin-left: 450px">角色管理&nbsp;&nbsp;&nbsp;<a href="<?= base_url('admin/roles/add') ?>" style="color: green" ><i class="fas fa-plus-square"></i></a></h3>
			<?php if($this->session->flashdata('delete_error')): ?>
				<div class="alert alert-danger" role="alert">
					<?= $this->session->flashdata('delete_error') ?>
				</div>
			<?php endif ?>
			<?php $index = 1; ?>
	<div class="row">
		<div class="card">
		<div class="card-body">
			<table style="width: 1000px"  id="datatable" class="table table-bordered table-hover">
				<thead>
					<tr>
						<td>順序</td>
						<td>角色名稱</td>
						<td>編輯</td>
						<td>刪除</td>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($roles)): ?>
						<?php foreach($roles as $role): ?>
						<tr>
							<td class="text-center"><?= $index ?></td>
							<td><?= ellipsize($role->name,20) ?></td>
							<td class="text-center"><a href="<?= base_url('admin/roles/edit').'/'.$role->id ?>"><i class="fas fa-edit"></i></a></td>
							<td class="text-center">
								<a class="delete" onclick="event.preventDefault();if(confirm('是否要刪除?')){ document.getElementById('delete<?= $role->id ?>').submit() }" style="cursor: pointer;color: firebrick;"><i class="fas fa-trash-alt"></i></a>
									<?= form_open(base_url('admin/roles/delete/'.$role->id),array(
										'style'	=> "display: hidden",
										'id'	=> "delete".$role->id
									)) ?>
									<input style="display: none" type="text" name="id" value="<?= $role->id ?>">
 		                           </form>
							</td>
						</tr>
						<?php $index++; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>