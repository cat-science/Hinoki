<?php echo $this->element('admin_menu');?>
<?php $this->start('script-embedded'); ?>
<script>	
	function downloadCSV()
	{
		var url = '<?php echo Router::url(array('action' => 'csv')) ?>/' + $('#MembersEventEventId').val() + '/' + $('#MembersEventStatus').val() + '/' + $('#MembersEventUsername').val();
		$("#RecordCmd").val("csv");
		$("#RecordAdminIndexForm").submit();
		$("#RecordCmd").val("");
	}
</script>
<?php $this->end(); ?>
<div class="admin-records-index col">
	<div class="ib-page-title"><?php echo __('ログイン履歴一覧'); ?></div>
	<div class="ib-horizontal">
		<?php
			echo $this->Form->create('Log',array('type' => 'get'));
			echo '<div class="ib-search-buttons">';
			echo $this->Form->submit(__('検索'),	array('class' => 'btn btn-info', 'div' => false));
			echo $this->Form->hidden('cmd');
			//echo '<button type="button" class="btn btn-default" onclick="downloadCSV()">'.__('CSV出力').'</button>';
			echo '</div>';

			echo '<div class="ib-row">';
			echo $this->Form->input('group_id',		array('label' => 'キャンパス :', 'options'=>$groups, 'selected'=>$group_id, 'empty' => '全て', 'required'=>false, 'class'=>'form-control'));
      echo $this->Form->input('username',			array('label' => 'ログインID :', 'value'=>$username, 'class'=>'form-control'));
      echo $this->Form->input('name',			array('label' => '氏名 :', 'value'=>$name, 'class'=>'form-control'));
      
      echo '</div>';
			
			
			echo $this->Form->end();
		?>
	</div>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
    <th nowrap><?php echo $this->Paginator->sort('User.username', 'ログインID'); ?></th>
		<th nowrap><?php echo $this->Paginator->sort('User.name', '氏名'); ?></th>
    <th class="ib-col-center"><?php echo $this->Paginator->sort('study_sec', 'ログイン時間'); ?></th>

	</tr>
	</thead>
	<tbody>
	<?php foreach ($login_records as $record): ?>
	<tr>
    <td><?php echo h($record['User']['username']); ?>&nbsp;</td>
		<td><?php echo h($record['User']['name']); ?>&nbsp;</td>
		<td class="ib-col-date"><?php echo h(Utils::getYMDHN($record['Log']['created'])); ?>&nbsp;</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?php echo $this->element('paging');?>
</div>
