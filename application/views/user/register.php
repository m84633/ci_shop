<div class="container" style="margin-top: 20px">
	<div class="row">
		<div class="col-4 offset-4">
			
			<?php if($errors): ?>
				<div class="alert alert-danger" role="alert">
					<?= array_shift($errors) ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="card bg-light col-6 offset-3">
		<article class="card-body mx-auto" style="max-width: 400px;">
			<h4 class="card-title mt-3 text-center"><b>會員註冊</b></h4>
<!-- 			<p>
				<a href="" class="btn btn-block btn-twitter"> <i class="fab fa-twitter"></i>   Login via Twitter</a>
				<a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i>   Login via facebook</a>
			</p>
			<p class="divider-text">
		        <span class="bg-light">OR</span>
		    </p>
 -->
 				<?= form_open(current_url()) ?>
					<div class="form-group input-group">
						<div class="input-group-prepend">
						    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
						 </div>
				        <input  name="name" value="<?= set_value('name') ?>" class="form-control" placeholder="姓名" type="text">
				    </div> <!-- form-group// -->
				    <div class="form-group input-group">
				    	<div class="input-group-prepend">
						    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
						 </div>
				        <input  name="email" class="form-control" value="<?= set_value('email') ?>" placeholder="Email" type="email">
				    </div> <!-- form-group// -->
				    <div class="form-group input-group">
				    	<div class="input-group-prepend">
						    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
						</div>
				        <input  class="form-control" name="password" placeholder="密碼" type="password">
				    </div> <!-- form-group// -->
				    <div class="form-group input-group">
				    	<div class="input-group-prepend">
						    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
						</div>
				        <input  class="form-control" name="passconf" placeholder="密碼確認" type="password">
				    </div> <!-- form-group// -->                                      
				    <div class="form-group">
				        <button type="submit" class="btn btn-primary btn-block"> 註冊  </button>
				    </div> <!-- form-group// -->      
			    <p class="text-center">已加入會員? <a href="<?= base_url('users/login') ?>">立即登入</a> </p>                                                                 
			</form>
		</article>
</div>
	</div>
</div>