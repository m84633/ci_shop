<div class="container" style="margin-top: 30px">
	<h3>購物明細</h3>
	<?php if(isset($_SESSION['error'])): ?>
		<div class="row">
			<div class="col-md-6">
				<div class="alert alert-danger" role="alert">
					<?= $_SESSION['error'] ?>			
				</div>
			</div>
		</div>
	<?php endif; ?>	
	<table class="table">
	  <thead class="thead-light">
	    <tr>
	      <th scope="col">商品明細</th>
	      <th scope="col">價格</th>
	      <th scope="col">數量</th>
	      <th scope="col">小計</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php foreach($user['cart'] as $product): ?>
	    <tr>
	      <td><strong><?= $product['item']->name ?></strong></td>
	      <td><?= $product['item']->price ?></td>
	      <td><?= $product['count'] ?></td>
	      <td><?= $product['item']->price*$product['count'] ?></td>
	    </tr>
	    <?php endforeach; ?>
	  </tbody>
	</table>
	<div class="float-right">
		<h6><strong>共<?= count($user['cart']) ?>項商品,數量<?= $user['total'] ?>個,總金額&nbsp;&nbsp;NT$&nbsp;<?= $user['sum'] ?></strong></h6>
	</div><br>
	<div class="p-2 bg-dark text-white" style="border-radius: 10px;">
		<div class="d-flex justify-content-end"><strong>本訂單須付款金額&nbsp;NT$&nbsp;&nbsp;<?= $user['sum'] ?>	元</strong></div>
	</div>
	<?= form_open(base_url('orders/add'),array('class'	=> 'mt-3')) ?>
	  	<div class="row">
	  		<div class="col-md-6">
			  	<div class="form-group">
				    <label for="exampleInputEmail1">姓名</label>&nbsp;<font style="color: red">*</font>
				    <input value="<?= set_value('name') ?>" type="text" class="form-control" name="name">
				</div>
	  		</div>
	  		<div class="col-md-6">
				<div class="form-group">
				    <label for="exampleInputPassword1">E-mail</label>&nbsp;<font style="color: red">(未填寫則使用註冊信箱)</font>
				    <input value="<?= set_value('email') ?>" type="email" class="form-control" name="email">
				</div>
	  		</div>
	  		<div class="col-md-6 offset-md-6">
	  			<div class="float-right">
					<a type="submit" href="<?= base_url('products/shop_cart') ?>" class="btn btn-secondary  shadow rounded mr-2"><strong>回到購物車</strong></a>
					<button type="submit" class="btn btn-warning border border-danger shadow rounded"><strong>送出訂單</strong></button>
	  			</div>
	  		</div>
	  	</div>

	</form>
</div>