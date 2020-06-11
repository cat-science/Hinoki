<?php echo $this->element('admin_menu');?>
<div class="col-11 mx-auto bg-light">
	<div class="h2"><?php echo __('ユーザ一覧'); ?></div>
	<div class="row justify-content-end mb-5">
		<?php if($loginedUser['role']=='admin'){ ?>
		<!-- <button type="button" class="btn btn-primary btn-export" onclick="location.href='<?php echo Router::url(array('action' => 'export')) ?>'">エクスポート</button> -->
		<!-- <button type="button" class="btn btn-primary btn-import" onclick="location.href='<?php echo Router::url(array('action' => 'import')) ?>'">インポート</button> -->
		<button type="button" class="btn btn-outline-primary btn-add" onclick="location.href='<?php echo Router::url(array('action' => 'add')) ?>'">+ 追加</button>
		<?php }?>
	</div>
		<?php
			
		?>
		<?php
			echo $this->Form->create('User',array(
				'class' => 'form-inline mb-3'
			));
		?>

		<?php
			echo $this->Form->input('group_id',		array(
				'label' => array(
					'text' => 'キャンパス : ',
					'class' => 'col-form-label mr-1'
				),
				'options'=>$groups, 
				'selected'=>$group_id, 
				'empty' => '全て', 
				'required'=>false, 
				'class' => 'form-control',
				'onchange' => 'submit(this.form);',
				'div' => 'form-group mb-2 mr-3'
			));
			echo $this->Form->input('username',		array(
				'label' => array(
					'text' => 'ログインID : ',
					'class' => 'col-form-label mr-1'
				), 
				'required' => false,
				'class' => 'form-control',
				'div' => 'form-group mb-2 mr-3',
				'style' => 'max-width: 150px'
			));
			echo $this->Form->input('name',			array(
				'label' => array(
					'text' => '氏名 : ',
					'class' => 'col-form-label mr-1'
				), 
				'required' => false,
				'class' => 'form-control',
				'div' => 'form-group mb-2 mr-3',
				'style' => 'max-width: 150px'
			));


		?>

		<input type="submit" class="btn btn-outline-info mb-2" value="検索">
		<?php
			echo $this->Form->end();
		?>

		<table class="table table-striped table-responsive-sm">
			<thead>
				<tr>
					<th nowrap><?php echo $this->Paginator->sort('username', 'ログインID'); ?></th>
					<th nowrap class=""><?php echo $this->Paginator->sort('name', '氏名'); ?></th>
					<th nowrap><?php echo $this->Paginator->sort('role', '権限'); ?></th>
					<th nowrap><?php echo __('所属キャンパス'); ?></th>
					<th nowrap class=""><?php echo __('Webテスト'); ?></th>
					<th nowrap class=""><?php echo __('受講科目'); ?></th>
					<th class=""><?php echo $this->Paginator->sort('last_logined', '最終ログイン日時'); ?></th>
					<?php if($loginedUser['role']=='admin') {?>
					<th class="ib-col-action"><?php echo __('Actions'); ?></th>
					<?php }?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user): ?>
				<tr>
					<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
					<td><?php echo h($user['User']['name']); ?></td>
					<td nowrap><?php echo h(Configure::read('user_role.'.$user['User']['role'])); ?>&nbsp;</td>
					<td><div class="reader" title="<?php echo h($user[0]['group_title']); ?>"><p><?php echo h($user[0]['group_title']); ?>&nbsp;</p></div></td>
					<td><div class="reader" title="<?php echo h($user[0]['course_title']); ?>"><p><?php echo h($user[0]['course_title']); ?>&nbsp;</p></div></td>
					<td><div class="reader" title="<?php echo h($user[0]['lecture_title']); ?>"><p><?php echo h($user[0]['lecture_title']); ?>&nbsp;</p></div></td>
					<td class=""><?php echo h(Utils::getYMDHN($user['User']['last_logined'])); ?>&nbsp;</td>
					<?php if($loginedUser['role']=='admin') {?>
					<td class="">
						<?php
							echo $this->Form->postLink(__('削除'), array(
								'action' => 'delete',
								$user['User']['id']
							), array(
								'class' => 'btn btn-outline-danger'
							), __('[%s] を削除してもよろしいですか?', $user['User']['name']));
					?>
					<button type="button" class="btn btn-outline-success"
							onclick="location.href='<?php echo Router::url(array('action' => 'edit', $user['User']['id'])) ?>'">編集</button>
					</td>
					<?php }?>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php echo $this->element('paging');?>
	</div>