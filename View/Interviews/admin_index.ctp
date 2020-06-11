<?php
  if($this->action == 'admin_index'){
    echo $this->element('admin_menu');
  }elseif($this->action == 'docent_index'){
    echo $this->element('docent_menu');
  }
?>
<div class="col-11 mx-auto bg-light">
	<div class="h2"><?php echo __('生徒一覧'); ?></div>

	<form class="form-inline mb-3 mt-3">
		<?php
			echo $this->Form->create(array(
				'type'=>'get',
			));
			
			echo $this->Form->input('group_id',		array(
				'label' => array(
					'text' => 'キャンパス : ',
					'class' => 'col-form-label mr-1'
				),
				'options'=>$group_list, 
				'selected'=>$group_id, 
				'empty' => '全て', 
				'required'=>false, 
				'class' => 'form-control',
				'div' => 'form-group mb-2 mr-3',
				'onchange' => ''
			));
			echo $this->Form->input('username',		array(
				'label' => array(
					'text' => 'ログインID : ',
					'class' => 'col-form-label mr-1'
				), 
				'class' => 'form-control',
				'div' => 'form-group mb-2 mr-3',
				'value' => $username,
				'required' => false,
				'style' => 'max-width: 150px'
			));
			echo $this->Form->input('name',			array(
				'label' => array(
					'text' => '氏名 : ',
					'class' => 'col-form-label mr-1'
				), 
				'class' => 'form-control',
				'div' => 'form-group mb-2 mr-3',
				'value' => $name,
				'required' => false,
				'style' => 'max-width: 150px'
			));
		?>
		<input type="submit" class="btn btn-outline-info mb-2"  value="検索">
		<?php
			echo $this->Form->end();
		?>
	</form>
	<table class="table table-striped table-responsive-sm">
	<thead>
	<tr>
		<th nowrap><?php echo $this->Paginator->sort('username', 'ログインID'); ?></th>
		<th nowrap><?php echo $this->Paginator->sort('name', '氏名'); ?></th>

		<th nowrap><?php echo __('所属キャンパス'); ?></th>

		<th nowrap><?php echo __('受講科目'); ?></th>

		<?php if($loginedUser['role']=='admin') {?>
		<th><?php echo __('Actions'); ?></th>
		<?php }?>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['name']); ?></td>
		<td><div class="reader" title="<?php echo h($user[0]['group_title']); ?>"><p><?php echo h($user[0]['group_title']); ?>&nbsp;</p></div></td>
    <td><div class="reader" title="<?php echo h($user[0]['lecture_title']); ?>"><p><?php echo h($user[0]['lecture_title']); ?>&nbsp;</p></div></td>
		<?php if($loginedUser['role']=='admin') {?>
		<td >
			<?php
				if($this->action == 'admin_index'){
					echo $this->Form->postLink(__('削除'), array(
						'action' => 'delete',
						$user['User']['id']
					), array(
						'class' => 'btn btn-outline-danger'
					), __('[%s] の面談記録を削除してもよろしいですか?', $user['User']['name']));
				}
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