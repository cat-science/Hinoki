<?php echo $this->element('admin_menu');?>
<div class="admin-interviews-index">
	<div class="ib-page-title"><?php echo __('生徒一覧'); ?></div>

	<div class="ib-horizontal">
		<?php
			echo $this->Form->create();
			echo $this->Form->input('group_id',		array(
				'label' => 'キャンパス : ', 
				'options'=>$groups, 
				'selected'=>$group_id, 
				'empty' => '全て', 
				'required'=>false, 
				'class' => 'form-control',
				'onchange' => 'submit(this.form);'
			));
			echo $this->Form->input('username',		array('label' => 'ログインID : ', 'required' => false));
			echo $this->Form->input('name',			array('label' => '氏名 : '  , 'required' => false));
		?>
		<input type="submit" class="btn btn-info btn-add" value="検索">
		<?php
			echo $this->Form->end();
		?>
	</div>
	<table>
	<thead>
	<tr>
		<th nowrap><?php echo $this->Paginator->sort('username', 'ログインID'); ?></th>
		<th nowrap class="col-width"><?php echo $this->Paginator->sort('name', '氏名'); ?></th>

		<th nowrap><?php echo __('所属キャンパス'); ?></th>

		<th nowrap class="ib-col-datetime"><?php echo __('受講科目'); ?></th>

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

		<td><div class="reader" title="<?php echo h($user[0]['group_title']); ?>"><p><?php echo h($user[0]['group_title']); ?>&nbsp;</p></td>
		
    <td><div class="reader" title="<?php echo h($user[0]['lecture_title']); ?>"><p><?php echo h($user[0]['lecture_title']); ?>&nbsp;</p></div></td>
		<?php if($loginedUser['role']=='admin') {?>
		<td class="ib-col-action">
			<?php
				echo $this->Form->postLink(__('削除'), array(
					'action' => 'delete',
					$user['User']['id']
				), array(
					'class' => 'btn btn-danger'
				), __('[%s] の面談記録を削除してもよろしいですか?', $user['User']['name']));
		?>
		<button type="button" class="btn btn-success"
				onclick="location.href='<?php echo Router::url(array('action' => 'edit', $user['User']['id'])) ?>'">編集</button>
		</td>
		<?php }?>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?php echo $this->element('paging');?>
</div>