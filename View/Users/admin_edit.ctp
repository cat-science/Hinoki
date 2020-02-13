<?php echo $this->element('admin_menu');?>
<?php echo $this->Html->css( 'select2.min.css');?>
<?php echo $this->Html->script( 'select2.min.js');?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
	$(function (e) {
		$('#GroupGroup').select2({placeholder:   "所属するキャンパスを選択して下さい。(複数選択可)", closeOnSelect: <?php echo (Configure::read('close_on_select') ? 'true' : 'false'); ?>,});
		$('#CourseCourse').select2({placeholder: "受講するWebテストを選択して下さい。(複数選択可)", closeOnSelect: <?php echo (Configure::read('close_on_select') ? 'true' : 'false'); ?>,});
		$('#LectureLecture').select2({placeholder: "受講する科目を選択して下さい。(複数選択可)", closeOnSelect: <?php echo (Configure::read('close_on_select') ? 'true' : 'false'); ?>,});

		// パスワードの自動復元を防止
		setTimeout('$("#UserNewPassword").val("");', 500);
	});
<?php $this->Html->scriptEnd(); ?>
<div class="admin-users-edit col">
<?php echo $this->Html->link(__('<< 戻る'), array('action' => 'index'))?>
	<div class="card bg-light">
		<div class="card-header">
			<?php echo ($this->request->data) ? __('編集') :  __('新規ユーザ'); ?>
		</div>
		<div class="card-body">
			<?php echo $this->Form->create('User', Configure::read('form_defaults_bs4')); ?>
			<?php
				$password_label = ($this->request->data) ? __('新しいパスワード') : __('パスワード');
				
				echo $this->Form->input('id');
				echo $this->Form->input('username',				array('label' => 'ログインID'));
				echo $this->Form->input('User.new_password',	array('label' => $password_label, 'type' => 'password', 'autocomplete' => 'new-password'));
				echo $this->Form->input('name',					array('label' => '氏名'));
				
				// root アカウント、もしくは admin 権限以外の場合、権限変更を許可しない
				$disabled = (($username == 'root')||($loginedUser['role']!='admin'));
				
				echo $this->Form->input('role',	array(
					'type' => 'radio',
					'before' => '<label class="col col-sm-3 control-label">権限</label>',
					'separator'=>"　", 
					'disabled'=>$disabled, 
					'legend' => false,
					'class' => false,
					'options' => Configure::read('user_role')
					)
				);
				
				echo $this->Form->input('email',				array('label' => 'メールアドレス'));
				echo $this->Form->input('Group',				array('label' => '所属キャンパス',	'size' => 20));
				
				echo $this->Form->input('Course',				array('label' => 'Webテスト',		'size' => 20));
				echo $this->Form->input('Lecture',				array('label' => '受講科目',		'size' => 20));
				echo $this->Form->input('comment',				array('label' => '備考'));
			?>
			<div class="form-group">
				<div class="col col-sm-9 col-sm-offset-3">
					<?php echo $this->Form->submit('保存', Configure::read('form_submit_defaults')); ?>
				</div>				
			</div>
			<?php echo $this->Form->end(); ?>
			<div class="col sol-sm-9 col-sm-offset-3">
				<?php
					if($this->request->data)
					{
						echo $this->Form->postLink(__('学習履歴を削除'), array(
							'action' => 'clear',
							$this->request->data['User']['id']
						), array(
							'class' => 'btn btn-danger '
						), __('学習履歴を削除してもよろしいですか？', $this->request->data['User']['name']));
					}
				?>
				</div>
			
		</div>
	</div>
</div>
