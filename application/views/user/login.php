<div class="container">
  <div class="row">
    <div class="col-4 offset-4" style="margin-top: 10px">
      <?= validation_errors() ?>
      <?php if(isset($login_error)): ?>
        <div class="alert alert-danger" role="alert">
          <?= ($login_error) ?? ''  ?>
        </div>  
      <?php endif; ?>
    </div>
    <div class="wrapper" >
      <div id="formContent">
        <div style="padding: 50px;">
            <div class="fadeIn first">
              <h3><b>會員登入</b></h3>
            </div>
            <?= form_open(current_url()) ?>
              <input required type="text" id="login" class="fadeIn second" name="email" placeholder="Email" value="<?= set_value('email') ?>" >
              <input required type="password" value="<?= set_value('password') ?>" id="password" class="fadeIn third" name="password" placeholder="密碼">
              <input type="submit" class="fadeIn fourth" value="登入">
            </form>
            <div id="formFooter">
              <a class="underlineHover" href="<?= base_url('users/forgot_password') ?>" style="color: CornflowerBlue;text-decoration: none">忘記密碼?</a><br>
              <a class="underlineHover" href="<?= base_url('users/register') ?>" style="color: CornflowerBlue;text-decoration: none">註冊</a>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>