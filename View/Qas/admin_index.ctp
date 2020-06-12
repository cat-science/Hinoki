<?php echo $this->element('admin_menu');?>
<script>
	
</script>
<?php $this->end(); ?>

<div class="col-11 mx-auto bg-light">
	<div class="h2"><?php echo __('Q & A一覧'); ?></div>

	<table id='sortable-table' class="table table-striped table-responsive-sm">
	<thead>
	<tr>
		<th nowrap>タイトル</th>
		<th >投稿者</th>
		<th >ステータス</th>
		<th >作成日時</th>
		<th ><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($qa_list as $qa): ?>
	<?php
		$title = $qa['Qa']['title'];
		$user_id = $qa['Qa']['user_id'];
		$user_name = $user_list[$user_id];
		$user_name = $qa['Qa']['is_anonymous'] == 1 ? $user_name . ' (匿名)' : $user_name;	
		$status = $qa['Qa']['is_public'] == 1 ? '公開' : '非公開';
	?>
	<tr>
		<td><?php echo $this->Html->link($title, array('controller' => 'qasRecords','action' => 'reply', $qa['Qa']['id']))?>&nbsp;</td>
		<td ><?php echo $user_name; ?>&nbsp;</td>
		<td ><?php echo $status;?>&nbsp;</td>
		<td ><?php echo Utils::getYMDHN($qa['Qa']['created']); ?>&nbsp;</td>
		<td >
			<?php
			echo $this->Form->hidden('id', array('id'=>'', 'class'=>'qa_id', 'value'=>$qa['Qa']['id']));
			
			if($loginedUser['role']=='admin')
			{
				echo $this->Form->postLink(__('削除'),
					array('action' => 'delete', $qa['Qa']['id']),
					array('class'=>'btn btn-outline-danger'),
					__('[%s] の投稿を削除してもよろしいですか?', $qa['Qa']['title'])
				);
			}?>
			<button type="button" class="btn btn-outline-success" onclick="location.href='<?php echo Router::url(array('action' => 'edit', $qa['Qa']['id'])) ?>'">編集</button>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
</div>
