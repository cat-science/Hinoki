<div class="col-12 col-sm-12 col-md-8 col-lg-6 mx-auto my-5">
	<div class="card">
		<div class="card-header">
			生徒ログイン
		</div>
	<div class="card-body">
		<div class="text-right mb-3"><a href="../admin/users/login">管理者ログインへ</a></div>
		<?php echo $this->Flash->render('auth'); ?>
		<?php echo $this->Form->create('User'); ?>
		<form>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label col-form-label-lg">ログインID</label>
				<?php 
					echo $this->Form->input('username', array(
						'label' => false,
						'class'=>'form-control form-control-lg', 
						'value' => $username,
						'div' => 'col-sm-8'
						)); 
				?>
			</div>

			<div class="form-group row">
				<label class="col-sm-4 col-form-label col-form-label-lg">パスワード</label>
				<?php 
					echo $this->Form->input('password', array(
						'label' => false,
						'class'=>'form-control form-control-lg', 
						'value' => $password,
						'div' => 'col-sm-8'
						)); 
				?>
			</div>

			<div class="form-group form-check mb-3">
				<input class="form-check-input" type="checkbox" name="data[User][remember_me]" checked="checked" value="1" id="remember_me">
				<label class="form-check-label" for="remember_me">ログイン状態を保持</label>
			</div>
			<?php echo $this->Form->unlockField('remember_me'); ?>
			<?php echo $this->Form->end(array('label' => 'ログイン', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
		</form>
	</div>
</div>