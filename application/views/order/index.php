<div style="margin-top: 50px" class="container">
	<?php if(isset($_SESSION['success']) && $_SESSION['success']): ?>
		<div class="alert alert-warning" role="alert">
				<?=$_SESSION['success']?>
		</div>
	<?php endif; ?>
	<input id="token" style="display: none" value="<?= $this->security->get_csrf_hash() ?>" type="text">
	<div class="modal fade" id="dmodal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
	    		<div class="modal-header">
	    			<b>訂單資料</b>
	    		</div>
	    		<div class="modal-body">
	    			<table class="table table-borderless">
					  <thead class="table-warning">
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
						</div><br>

	    		</div>
			</div>
		</div>
	</div>
	<table class="table">
  <thead class="table-success">
    <tr>
      <th scope="col">訂單編號</th>
      <th scope="col">總額</th>
      <th scope="col">付款狀態</th>
      <th scope="col">建立日期</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  	<?php foreach($orders as $order): ?>
	    <tr>
	      <th scope="row"><?= $order->uuid ?></th>
	      <td><?= unserialize($order->cart)['sum'] ?></td>
	      <td><?= $order->payment ? '已付款':'尚未付款' ?></td>
	      <td><?= $order->created_at ?></td>
	      <td><span class="show-modal" data-id="<?= $order->id ?>"  data-toggle="modal"  style="cursor: pointer;color: DodgerBlue">詳細資料</span></td>
	    </tr>
	<?php endforeach; ?>
  </tbody>
</table>
</div>