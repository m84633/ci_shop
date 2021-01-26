<div style="margin-top: 50px" class="container">
			<h3 style="margin-left: 450px">會員管理&nbsp;&nbsp;&nbsp;
				<?php if(in_array('4',$permissions)): ?>
					<a href="<?= base_url('admin/users/add') ?>" style="color: green" ><i class="fas fa-plus-square"></i></a>
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
						<td>會員編號</td>
						<td>會員名稱</td>
						<td>電子郵件</td>
						<?php if(in_array('5',$permissions)): ?>
							<td>編輯</td>
						<?php endif; ?>
						<?php if(in_array('6',$permissions)): ?>
							<td>刪除</td>
						<?php endif; ?>	
					</tr>
				</thead>
				<tbody>
					<?php if(isset($users)): ?>
						<?php foreach($users as $user): ?>
						<tr>
							<td class="text-center"><?= $user->id ?></td>
							<td><?= ellipsize($user->name,20) ?></td>
							<td><?= $user->email ?></td>
							<?php if(in_array('5',$permissions)): ?>
								<td class="text-center"><a href="<?= base_url('admin/users/edit').'/'.$user->id ?>"><i class="fas fa-edit"></i></a></td>
							<?php endif; ?>
							<?php if(in_array('6',$permissions)): ?>
							<td class="text-center">
								<a class="delete" onclick="event.preventDefault();if(confirm('是否要刪除?')){ document.getElementById('delete<?= $user->id ?>').submit() }" style="cursor: pointer;color: firebrick;"><i class="fas fa-trash-alt"></i></a>
									<?= form_open(base_url('admin/users/delete/'.$user->id),array(
										'style'	=> "display: hidden",
										'id'	=> "delete".$user->id
									)) ?>
										<input style="display: none" type="text" name="id" value="<?= $user->id ?>">
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