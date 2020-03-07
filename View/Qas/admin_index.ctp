<?php echo $this->element('admin_menu');?>
<script>
	
</script>
<?php $this->end(); ?>

<div class="admin-qas-index col">
	<div class="row">
		<div class="col-8">
			<p class="h1"><?php echo __('Q & A一覧'); ?></p>
		</div>
	</div>

	<table id='sortable-table'>
	<thead>
	<tr>
		<th nowrap>タイトル</th>
		<th class="text-center">投稿者</th>
		<th class="text-center">ステータス</th>
		<th class="ib-col-date">作成日時</th>
		<th class="ib-col-action"><?php echo __('Actions'); ?></th>
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
		<td><?php echo $this->Html->link($title, array('controller' => 'qasrecords','action' => 'reply', $qa['Qa']['id']))?>&nbsp;</td>
		<td class="text-center"><?php echo $user_name; ?>&nbsp;</td>
		<td class="text-center"><?php echo $status;?>&nbsp;</td>
		<td class="ib-col-date"><?php echo Utils::getYMDHN($qa['Qa']['created']); ?>&nbsp;</td>
		<td class="ib-col-action">
			<?php
			echo $this->Form->hidden('id', array('id'=>'', 'class'=>'qa_id', 'value'=>$qa['Qa']['id']));
			
			if($loginedUser['role']=='admin')
			{
				echo $this->Form->postLink(__('削除'),
					array('action' => 'delete', $qa['Qa']['id']),
					array('class'=>'btn btn-danger'),
					__('[%s] の投稿を削除してもよろしいですか?', $qa['Qa']['title'])
				);
			}?>
			<button type="button" class="btn btn-success" onclick="location.href='<?php echo Router::url(array('action' => 'edit', $qa['Qa']['id'])) ?>'">編集</button>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
</div>
