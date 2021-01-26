<input id="token" style="display: none" value="<?= $this->security->get_csrf_hash() ?>" type="text">
<div class="modal fade" id="dmodal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
    		<div class="modal-header">
    			<b>訂單資料</b>
    		</div>
    		<div class="modal-body">
    			<table class="table table-borderless">
				  <thead class="table-info">
				    <tr>
				      <th scope="col">商品</th>
				      <th scope="col">數量</th>
				      <th scope="col">單價</th>
				      <th scope="col">總額</th>
				    </tr>
				  </thead>
				  <tbody id="d_body">
					    <tr>
					      <th scope="row">1</th>
					      <td>2</td>
					      <td>3</td>
					      <td>4</td>
					    </tr>
				  </tbody>
				</table>
					<div class="float-right">
						<h6><strong>共<span id="d_item"></span>項商品,數量<span id="d_count"></span>個,總金額&nbsp;&nbsp;NT$&nbsp;<span id="d_price"></span></strong></h6>
					</div>
    		</div>
		</div>
	</div>
</div>
<div style="margin-top: 50px" class="container">
			<h3 style="margin-left: 450px">訂單管理&nbsp;&nbsp;&nbsp;<a href="<?= base_url('admin/orders/add') ?>" style="color: green" ><i class="fas fa-plus-square"></i></a></h3>
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
						<td>訂單編號</td>
						<td>訂購者</td>
						<td>Email</td>
						<td>總額</td>
						<td>狀態</td>
						<td>日期</td>
						<td>購買資訊</td>
						<td>刪除</td>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($orders)): ?>
						<?php foreach($orders as $order): ?>
						<tr>
							<td class="text-center"><?= $order->uuid ?></td>
							<td><?= ellipsize($order->name,20) ?></td>
							<td><?= $order->email ?></td>
							<td><?= unserialize($order->cart)['sum'] ?></td>
							<td><?= $order->payment ? '已付款':'尚未付款' ?></td>
							<td><?= $order->created_at ?></td>
							<td class="text-center"><a class="show-modal" data-id="<?= $order->id ?>" style="cursor: pointer;color:CadetBlue"  ><i class="fas fa-bullseye"></i></a></td>
							<td class="text-center">
								<a class="delete" onclick="event.preventDefault();if(confirm('是否要刪除?')){ document.getElementById('delete<?= $order->id ?>').submit() }" style="cursor: pointer;color: firebrick;"><i class="fas fa-trash-alt"></i></a>
									<?= form_open(base_url('admin/orders/delete/'.$order->id),array(
										'style'	=> "display: hidden",
										'id'	=> "delete".$order->id
									)) ?>
									<input style="display: none" type="text" name="id" value="<?= $order->id ?>">
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