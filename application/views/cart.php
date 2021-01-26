<div class="container">
<!--Section: Block Content-->
<section>
  <!--Grid row-->
  <?php if(isset($_SESSION['cart']) && $_SESSION['cart']): ?>
  <div id="total_item" class="row">

    <!--Grid column-->
    <div class="col-lg-8">

      <!-- Card -->
      <div class="mb-3">
        <div class="pt-4 wish-list">
          <h5 class="mb-4">購物車 (共<span class="total"><?= $user['total'] ?></span> 件商品)</h5>
          <input style="display: none" id="token" value="<?=$this->security->get_csrf_hash();?>" type="text">
          <?php foreach($user['cart'] as $cart): ?>
          <div id="item<?= $cart['item']->id ?>" style="height: 175px" class="row mb-4">
            <div class="col-md-5 col-lg-3 col-xl-3">
              <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                <img class="img-fluid w-100"
                  src="<?= base_url().'uploads/'.$cart['item']->image ?>" alt="Sample">
              </div>
            </div>
            <div class="col-md-7 col-lg-9 col-xl-9">
              <div >
                <div class="">
                	<div  class="row">
	                  <div class="col-md-11">
	                    <h6><?= $cart['item']->name ?></h6>
	                  </div>
                	</div>
                  <div>
                    <div style="margin-top: 20px" class="def-number-input number-input safari_only mb-0 w-100">
						<i style="cursor: pointer"  data-id="<?=$cart['item']->id?>"   class="fas fa-minus"></i>
                      <input readonly id="<?= $cart['item']->id ?>" class="quantity" min="1" name="quantity" value="<?= $cart['count'] ?>">
                      	<i style="cursor: pointer" data-id="<?=$cart['item']->id  ?>"  class="fas fa-plus"></i>
                    </div>
                  </div>
                </div>
                <div  class="d-flex justify-content-between align-items-center">
                  <div style="margin-top:20px">
                    <a style="cursor: pointer"  data-id="<?=$cart['item']->id?>" type="button" class="card-link-secondary small text-uppercase mr-3 unset"><i
                        class="fas fa-trash-alt mr-1"></i>移除物品</a>
                  </div>
                  <p class="mb-0"><span><strong id="summary<?= $cart['item']->id ?>"><?= $cart['item']->price*$cart['count'] ?></strong></span></p class="mb-0">
                </div>
              </div>
            </div>
          </div>
      <?php endforeach; ?>


        </div>
      </div>
      <!-- Card -->

    </div>
    <!--Grid column-->

    <!--Grid column-->
    <div class="col-lg-4">

      <!-- Card -->
      <div style="margin-top:50px" class="mb-3">
        <div class="pt-4">

          <h5 class="mb-3">總計</h5>

          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
              小計
              <span id="temporary"><?=$user['sum']?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
              其他費用
              <span>0</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
              <div>
                <strong>總額</strong>
              </div>
              <span><strong id="sum"><?=$user['sum']?></strong></span>
            </li>
          </ul>

          <a href="<?= base_url('products/checkout') ?>" type="button" class="btn btn-primary btn-block">前往結帳</a>

        </div>
      </div>
    </div>
    <!--Grid column-->

  </div>
  <?php else: ?>
  <h3 style="margin-top: 100px">目前購物車無任何商品 <br><a style="margin-top: 10px" class="btn btn-info btn-md" href="<?= base_url() ?>">前往商店</a></h3>
  <?php endif; ?>
  <!-- Grid row -->

</section>
</div>
<!--Section: Block Content-->