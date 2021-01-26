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
		  <a class="navbar-brand text-primary" href="<?= base_url('admins/index') ?>"><b><i>Ez</i>Book</b></a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
        	<?php if(isset($permissions) && $permissions): ?>
		    <ul class="navbar-nav ml-auto">
		      <li class="nav-item dropdown">
			        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			         <?= $admin['admin_name'] ?>
			        </a>
			        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        			<?php if(in_array('1',$permissions) || in_array('2',$permissions) || in_array('3',$permissions)): ?>
			          <a class="dropdown-item" href="<?= base_url('admins') ?>">商品管理</a>
			        <?php endif; ?>
			        <?php if(in_array('8',$permissions)): ?>
			          <a class="dropdown-item" href="<?= base_url('admin/types') ?>">類別管理</a>
			        <?php endif; ?>
        			<?php if(in_array('4',$permissions) || in_array('5',$permissions) || in_array('6',$permissions)): ?>
			          <a class="dropdown-item" href="<?= base_url('admin/users') ?>">會員管理</a>
			        <?php endif; ?>
			        <?php if(in_array('7',$permissions)): ?>
			          <a class="dropdown-item" href="<?= base_url('admin/managers') ?>">成員管理</a>
			        <?php endif; ?>
			        <?php if(in_array('9',$permissions)): ?>
			          <a class="dropdown-item" href="<?= base_url('admin/orders') ?>">訂單管理</a>
			        <?php endif; ?>
			        <?php if(in_array('12',$permissions)): ?>
			          <a class="dropdown-item" href="<?= base_url('admin/roles') ?>">角色管理</a>
			        <?php endif; ?>
			        <?php if(in_array('10',$permissions)): ?>
			          <a class="dropdown-item" href="<?= base_url('admin/permissions') ?>">權限管理</a>
			        <?php endif; ?>
			          <div class="dropdown-divider"></div>
			          <a class="dropdown-item" href="<?= base_url('admins/logout') ?>">登出</a>
			        </div>
		      </li>
		    </ul>
				<?php else: ?>
			<ul class="navbar-nav ml-auto">
		      <li class="nav-item dropdown">
			        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			         <?= $admin['admin_name'] ?>
			        </a>
			        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			        	<a class="dropdown-item" href="<?= base_url('admins/logout') ?>">登出</a>
			        </div>
			    </li>
			</ul>
				<?php endif; ?>	        
		  </div>
		</div>
	</nav>