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
<div class="col-11 mx-auto bg-light mb-5">
	<div class="h2"><?php echo __('ログイン履歴一覧'); ?></div>
	
	
	<div class="">

		<?php
			echo $this->Form->create('Log',array('type' => 'get'));
		?>
		<div class="row mb-3">
    	<div class="col-4 offset-8 col-md-2 offset-md-10">
				<?php
					echo $this->Form->submit(__('検索'),	array(
						'class' => 'btn btn-outline-info', 
						'div' => false
					));
					echo $this->Form->hidden('cmd');
				?>
    	</div>
		</div>
		<?php
			/********************************************** */
			echo '<div class="form-group row">';
			echo $this->Form->input('group_id',		array(
				'label' => array(
					'class' => 'col-form-label ml-3 mr-2',
					'text' => 'キャンパス :'
				), 
				'options'=>$groups, 
				'selected'=>$group_id, 
				'empty' => '全て', 
				'required'=>false, 
				'class'=>'form-control',
				'div' => false,
			));
			echo '</div>';
			/********************************************** */

			/********************************************** */
			echo '<div class="form-group row">';

      echo $this->Form->input('username',		array(
				'label' => array(
					'class' => 'col-form-label ml-3 mr-2',
					'text' => 'ログインID :'
				), 
				'value'=>$username, 
				'class'=>'form-control',
				'div' => false,
			));

      echo $this->Form->input('name',			array(
				'label' => array(
					'class' => 'col-form-label ml-3 mr-2',
					'text' => '氏名 :'
				), 
				'value'=>$name, 
				'class'=>'form-control',
				'div' => false,
			));
      
      echo '</div>';
			/********************************************** */
			
			
			echo $this->Form->end();
		?>
	</div>
	<table cellpadding="0" cellspacing="0" class="table table-striped table-responsive-sm">
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
