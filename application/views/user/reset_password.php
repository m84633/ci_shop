<div style="margin-top: 100px" class="page-wrap d-flex flex-row align-items-center">
    <div class="container">
    	<div class="row">
    		<div class="offset-3 col-md-6">
    		    <h2 class="font-weight-light">新密碼</h2>
                <?= validation_errors() ?>
                <?php if(isset($error) && $error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($success) && $success): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $success ?><br>
                        <a href="<?=base_url('users/login')?>">登入</a>
                    </div>
                <?php endif; ?>
    		    請輸入新密碼
                <?= form_open(current_url().'?token='.$_GET['token'],array(
                    'class' => 'mt-3'
                )) ?>
    		        <input required class="form-control form-control-lg" name="password" type="password" placeholder="密碼"/><br>
                    <input required class="form-control form-control-lg" name="confpasswd" type="password" placeholder="請再輸入一次密碼"/>
    		        
    		        <div class="text-right my-3">
    		            <button type="submit" class="btn btn-md btn-info">送出</button>
    		        </div>
    		    </form>
    		</div>
    	</div>
    </div>
</div>