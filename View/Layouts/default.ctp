<?php
/**
 * iroha Board Project
 *
 * @author        Kotaro Miura
 * @copyright     2015-2016 iroha Soft, Inc. (http://irohasoft.jp)
 * @link          http://irohaboard.irohasoft.jp
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	
	<title><?php echo h($this->Session->read('Setting.title')); ?></title>
	<meta name="application-name" content="iroha Board">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<?php
		// 管理画面フラグ（ログイン画面は例外とする）
		$is_admin_page = (($this->params['admin']==1)&&($this->params['action']!='admin_login'));
		
		// 講師画面フラグ (ログイン画面は例外とする)
		$is_docent_page = (($this->params['docent']==1)&&($this->params['action']!='docent_login'));
		
		// 受講者向け画面及び、管理システムのログイン画面のみ viewport を設定（スマートフォン対応）
		if(!$is_admin_page || !$is_docent_page)
			echo '<meta name="viewport" content="width=device-width,initial-scale=1">';
		
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('jquery-ui');
		echo $this->Html->css('bootstrap.min'); // v4.4
		echo $this->Html->css('bootstrap'); // v4.4
		echo $this->Html->css('summernote-bs4'); // v4.4

		echo $this->Html->css('common.css?20190401');
		
		// 管理画面用CSS
		if($is_admin_page)
			echo $this->Html->css('admin.css?20190401');

		// カスタマイズ用CSS
		echo $this->Html->css('custom.css?20190401');
		
		// echo $this->Html->script('jquery-1.9.1.min.js');
		// echo $this->Html->script('jquery-ui-1.9.2.min.js');
		echo $this->Html->script('jquery-3.4.1.min.js');
		echo $this->Html->script('Popper.js');
		echo $this->Html->script('bootstrap.min.js');	// v4.4
		echo $this->Html->script('bootstrap.js');	// v4.4
		echo $this->Html->script('bootstrap.bundle.js'); // v4.4
		echo $this->Html->script('summernote-bs4.js'); // v4.4
		echo $this->Html->script('moment.js');
		echo $this->Html->script('common.js?20190401');
		
		// 管理画面用スクリプト
		if($is_admin_page)
			echo $this->Html->script('admin.js?20190401');
		
		// デモモード用スクリプト
		if(Configure::read('demo_mode'))
			echo $this->Html->script('demo.js');
		
		// カスタマイズ用スクリプト
		echo $this->Html->script('custom.js?20190401');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->fetch('css-embedded');
		echo $this->fetch('script-embedded');
	?>
	<style>
		.ib-theme-color
		{
			background-color	: <?php echo h($this->Session->read('Setting.color')); ?>;
			color				: white;
		}
		
		.ib-logo a
		{
			color				: white;
			text-decoration		: none;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-expand-sm navbar-dark" style="background-color: <?php echo h($this->Session->read('Setting.color')); ?>;">
	<?php $top_url = (($loginedUser['role']=='admin') && (!$is_admin_page)) ? '/admin/recentstates' : '/'; ?>
	<?php 
		/** 
		 * adminページ 	 => docentページ 
		 * docentページ  => userページ
		 * userページ 	 => adminページ
		 */
		if($loginedUser['role'] == 'admin' && ($is_admin_page) && (!$is_docent_page)){
			$top_url = '/docent/lectures';
		}else if($loginedUser['role'] == 'admin' && (!$is_admin_page) && ($is_docent_page)){
			$top_url = '/';
		}else if($loginedUser['role'] == 'admin' && (!$is_admin_page) && (!$is_docent_page)){
			$top_url = '/admin/users';
		}else if($loginedUser['role'] == 'docent' && (!$is_admin_page) && ($is_docent_page)){
			$top_url = '/';
		}else if($loginedUser['role'] == 'docent' && (!$is_admin_page) && (!$is_docent_page)){
			$top_url = '/docent/lectures';
		}else{
			$top_url = '/';
		}
	?>	
	<a class="navbar-brand" href="<?php echo $this->Html->url($top_url)?>"><?php echo h($this->Session->read('Setting.title')); ?></a>
	<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#Navber" aria-controls="Navber" aria-expanded="false" aria-label="ナビゲーションの切替">
		<span class="navbar-toggler-icon"></span>
	</button>
	<?php if(@$loginedUser) {?>
	<div class="collapse navbar-collapse" id="Navber">
		<?php echo $this->fetch('menu'); ?>
		<ul class="navbar-nav mt-2 mt-sm-0">
			<li class="nav-item dropdown">
				<a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php echo h($loginedUser["name"]); ?>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
					<?php echo $this->Html->link(__('設定'), array('controller' => 'users', 'action' => 'setting'), array('class' => 'dropdown-item')); ?>
					<div class="dropdown-divider"></div>
					<?php echo $this->Html->link(__('ログアウト'), $logoutURL, array('class' => 'dropdown-item')); ?>
				</div>
			</li>
		</ul>
	</div><!-- /.navbar-collapse -->
	<?php }?>
	</nav>
	
	<div id="container">
		<div id="header" class="row">
		</div>
		<div id="content" class="row">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer" class="row">
		</div>
	</div>
	
	<div class="ib-theme-color text-center">
		<?php echo h($this->Session->read('Setting.copyright')); ?>
	</div>
	
	<div class="irohasoft">
		Powered by <a href="http://irohaboard.irohasoft.jp/">iroha Board</a>
	</div>
	
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
