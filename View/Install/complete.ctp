<?php
$url = Router::url(array('controller' => 'users', 'action' => 'login'));
$url = str_replace('/users/', '/admin/users/', $url);
?>
<div class="install-complete">
	<div class="card bg-light">
		<div class="card-header">
			Hinoki Installer
		</div>
		<div class="card-body">
			<p class="msg">
				インストールが完了しました<br>
				<br>
				以下のログインIDとパスワードでログイン可能です。<br>
				ログインID : root<br>
				パスワード : 入力されたパスワード<br>
			</p>
		</div>
		<div class="panel-footer text-center">
			<button class="btn btn-primary" onclick="location.href='<?php echo $url;?>'">管理者ログイン画面へ</button>
		</div>
	</div>
</div>
