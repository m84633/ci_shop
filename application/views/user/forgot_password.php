<div  class="page-wrap d-flex flex-row align-items-center">
    <div class="container">
    	<div class="row">
    		<div class="offset-3 col-md-6">
    		    <h2 class="font-weight-light">忘記密碼?</h2>
                <?= validation_errors() ?>
                <?php if(isset($error) && $error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($success) && $success): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $success ?>
                    </div>
                <?php endif; ?>
    		    請輸入您的email,並重置密碼!!
                <?= form_open(current_url(),array(
                    'class' => 'mt-3'
                )) ?>
    		        <input required class="form-control form-control-lg" name="email" type="email" placeholder="Email"/>
    		        
    		        <div class="text-right my-3">
    		            <button type="submit" class="btn btn-md btn-info">送出</button>
    		        </div>
    		    </form>
    		</div>
    	</div>
    </div>
</div>