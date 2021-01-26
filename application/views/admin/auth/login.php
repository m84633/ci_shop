<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理員登入</title>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?= base_url().'/assets/admin_login.css' ?>" rel="stylesheet">

</head>
<body>
    <div class="container" style="margin-top: 180px">
    <div class="row">
        <div class="col-md-offset-6 col-md-4">
            <?php if(isset($errors) && $errors): ?>
                <div class="alert alert-danger" role="alert">
                    <?= array_shift($errors) ?>
                </div>
            <?php endif; ?>
            <?php if(isset($login_error)): ?>
                <div class="alert alert-danger" role="alert">
                  <?= ($login_error) ?? ''  ?>
                </div>  
            <?php endif; ?>
            <?= form_open(current_url()) ?>
                <div class="form-login">
                    <h3><b>管理員登入</b></h3>
                    <input type="text" name="username" id="userName" class="form-control input-sm chat-input" placeholder="帳號" />
                    </br>
                    <input type="password" name="password" id="userPassword" class="form-control input-sm chat-input" placeholder="密碼" />
                    </br>
                    <div class="wrapper">
                    <span class="group-btn">     
                        <button class="btn btn-primary btn-md" type="submit">登入</button>
                    </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>