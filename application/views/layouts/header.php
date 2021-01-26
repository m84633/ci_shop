<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title ?></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
	<?php if(isset($links)): ?>
		<?php foreach($links as $link): ?>
			<link rel="stylesheet" href="<?= $link ?>">
		<?php endforeach; ?>
	<?php endif; ?>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light  table-info">
		<div class="container">
		  <a class="navbar-brand text-primary" href="<?= base_url() ?>"><b><i>Ez</i>Book</b></a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  	<?= form_open(base_url(),[
		  		'method' => 'get',
		  		'class'  => 'form-inline my-2 my-lg-0'
		  	]) ?>
		      <input class="form-control mr-sm-2" name="search" type="search" placeholder="請輸入...">
		      <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">搜尋</button>
		    </form>
		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav ml-auto">
	      	<li class="nav-item">
       	 		<a style="color: red" class="nav-link" href="<?= base_url('products/shop_cart') ?>" tabindex="-1"><i class="fas fa-cart-plus"></i>&nbsp;
       	 				<span id="total"  <?= isset($user['total']) ? '':'style="display:none"'  ?> class="badge badge-light total">
       	 					<?= $user['total'] ?>
       	 				</span>
       	 		</a>
      		</li>
		    <?php if(isset($user['login']) && $user['login']): ?>
		    <li class="nav-item">
                    <img src="<?= base_url('uploads/').(isset($user['avatar']) ? $user['user_id']."/".$user['avatar'] : 'default.jpg'); ?>" style="width: 30px; height: 30px;" class="rounded-circle mt-1">
            </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          <?= $user['name'] ?>
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="<?= base_url('users/edit/'.$user['user_id']) ?>">修改會員資料</a>
		          <a class="dropdown-item" href="<?= base_url('orders') ?>">訂單查詢</a>
		          <div class="dropdown-divider"></div>
		          <a class="dropdown-item" href="<?= base_url('users/logout') ?>">登出</a>
		        </div>
		      </li>
		  <?php else: ?>
		  	<li class="nav-item">
		  		<a class="text-muted nav-link" style="text-decoration: none;" href="<?= base_url('users/login') ?>">登入</a>
		  	</li>
		  <?php endif; ?>
		    </ul>
		  </div>
		</div>
	</nav>