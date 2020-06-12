<?php
	if($this->action == 'admin_all_records'){
		echo $this->element('admin_menu');
	}elseif($this->action == 'docent_all_records'){
		echo $this->element('docent_menu');
	}
?>
<?php $this->start('script-embedded'); ?>
<script>
	function openRecord(course_id, user_id)
	{
		window.open(
			'<?php echo Router::url(array('controller' => 'contents', 'action' => 'record')) ?>/'+course_id+'/'+user_id,
			'irohaboard_record',
			'width=1100, height=700, menubar=no, toolbar=no, scrollbars=yes'
		);
	}
	
	function openTestRecord(content_id, record_id)
	{
		window.open(
			'<?php echo Router::url(array('controller' => 'contents_questions', 'action' => 'record')) ?>/'+content_id+'/'+record_id,
			'irohaboard_record',
			'width=1100, height=700, menubar=no, toolbar=no, scrollbars=yes'
		);
	}
	
	function downloadCSV()
	{
		var url = '<?php echo Router::url(array('action' => 'csv')) ?>/' + $('#MembersEventEventId').val() + '/' + $('#MembersEventStatus').val() + '/' + $('#MembersEventUsername').val();
		$("#RecordCmd").val("csv");
		$("#RecordAdminAllRecordsForm").submit();
		$("#RecordCmd").val("");
	}
</script>
<?php $this->end(); ?>
<div class="col-11 mx-auto mb-5 bg-light">
  <div class="h2"><?php echo __($user_info['User']['name'].'のWebテスト成績一覧'); ?></div>
		<?php
			echo $this->Form->create('Record',array(
				'type' => 'get',
				'class' => 'form-inline mb-3'
			));
      
      
			// echo '<button type="button" class="btn btn-outline-secondary" onclick="downloadCSV()">'.__('CSV出力').'</button>';
			
			echo $this->Form->input('course_id', array(
				'label' => array(
					'text' => 'Webテスト :',
					'class' => 'col-form-label mr-1'
				),
				'options'=>$courses, 
				'selected'=>$course_id, 
				'empty' => '全て', 
				'required'=>false, 
				'class'=>'form-control',
				'div' => 'form-group mb-2 mr-3'

			));
			//echo $this->Form->input('content_category',	array('label' => 'コンテンツ種別 :', 'options'=>Configure::read('content_category'), 'selected'=>$content_category, 'empty' => '全て', 'required'=>false, 'class'=>'form-control'));
			echo $this->Form->input('contenttitle',		array(
				'label' => array(
					'text' => 'コンテンツ名 :',
					'class' => 'col-form-label mr-1'
				),
				'value'=>$contenttitle, 
				'class'=>'form-control',
				'div' => 'form-group mb-2 mr-3'

			));
      echo $this->Form->input('name',	array(
				'label' => array(
					'text' => '氏名 :',
					'class' => 'col-form-label mr-1'
				),
        'value'=>$name, 
        'class'=>'form-control', 
        'id' => 'disabledInput',
        'value' => $user_info['User']['name'],
				'disabled',
				'div' => 'form-group mb-2 mr-3'
		
			));
			
			echo $this->Form->submit(__('検索'),	array(
				'class' => 'btn btn-outline-primary mb-2', 
				'div' => false
			));
			echo $this->Form->hidden('cmd');
      
			echo $this->Form->end();
		?>
	<table class="table table-striped table-responsive-sm">
	<thead>
	<tr>
		<th nowrap><?php echo $this->Paginator->sort('course_id', 'Webテスト'); ?></th>
		<th nowrap><?php echo $this->Paginator->sort('content_id', 'コンテンツ'); ?></th>
		<th nowrap><?php echo $this->Paginator->sort('User.name', '氏名'); ?></th>
		<th nowrap ><?php echo $this->Paginator->sort('score', '得点'); ?></th>
		<th nowrap><?php echo $this->Paginator->sort('pass_score', '合格点'); ?></th>
		<th nowrap ><?php echo $this->Paginator->sort('is_passed', '結果'); ?></th>
		<th nowrap><?php echo $this->Paginator->sort('understanding', '理解度'); ?></th>
		<th ><?php echo $this->Paginator->sort('study_sec', '学習時間'); ?></th>
		<th ><?php echo $this->Paginator->sort('created', '学習日時'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($records as $record): ?>
	<tr>
		<td><a href="javascript:openRecord(<?php echo h($record['Course']['id']); ?>, <?php echo h($record['User']['id']); ?>);"><?php echo h($record['Course']['title']); ?></a></td>
		<td><?php echo h($record['Content']['title']); ?>&nbsp;</td>
		<td><?php echo h($record['User']['name']); ?>&nbsp;</td>
		<td ><?php echo h($record['Record']['score']); ?>&nbsp;</td>
		<td ><?php echo h($record['Record']['pass_score']); ?>&nbsp;</td>
		<td nowrap ><a href="javascript:openTestRecord(<?php echo h($record['Content']['id']); ?>, <?php echo h($record['Record']['id']); ?>);"><?php echo Configure::read('record_result.'.$record['Record']['is_passed']); ?></a></td>
		<td nowrap ><?php echo h(Configure::read('record_understanding.'.$record['Record']['understanding'])); ?>&nbsp;</td>
		<td ><?php echo h(Utils::getHNSBySec($record['Record']['study_sec'])); ?>&nbsp;</td>
		<td ><?php echo h(Utils::getYMDHN($record['Record']['created'])); ?>&nbsp;</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?php echo $this->element('paging');?>
</div>
