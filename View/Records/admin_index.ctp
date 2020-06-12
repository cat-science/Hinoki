<?php echo $this->element('admin_menu');?>
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
		$("#RecordAdminIndexForm").submit();
		$("#RecordCmd").val("");
	}
</script>
<?php $this->end(); ?>
<div class="col-11 mx-auto bg-light">
	<div class="h2"><?php echo __('学習履歴一覧'); ?></div>
	<div class="">
		<?php
			echo $this->Form->create('Record',array(
				'class' => 'mb-3'
			));
			?>
			<div class="row mb-3">
    		<div class="col-8 offset-6 col-md-3 offset-md-9">
					<?php
						echo $this->Form->submit(__('検索'),	array(
							'class' => 'btn btn-outline-primary mr-3', 
							'div' => false
						));
						echo '<button type="button" class="btn btn-outline-secondary" onclick="downloadCSV()">'.__('CSV出力').'</button>';
						echo $this->Form->hidden('cmd');
					?>	
    		</div>
  		</div>
			<?php

			/********************************************** */
			echo '<div class="form-group row">';
			echo $this->Form->input('course_id',	array(
				'label' => array(
					'class' => 'col-form-label ml-3 mr-2',
					'text' => 'Webテスト :'
				), 
				'options'=>$courses, 
				'selected'=>$course_id, 
				'empty' => '全て', 
				'type' => 'select',
				'required'=>false, 
				'class'=>'form-control', 
				'div' => false,
				// 'div' => 'form-group row'
			));

			echo $this->Form->input('contenttitle',	array(
				'label' => array(
					'class' => 'col-form-label ml-3 mr-2',
					'text' => 'コンテンツ名 :'
				),  
				'value'=>$contenttitle, 
				'class'=>'form-control',
				'div' => false,
			));

			echo '</div>';
			/********************************************** */

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

			echo $this->Form->input('name',		array(
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

			
			
			echo '<div class="form-group row">';
			echo $this->Form->input('from_date', array(
				'label' => array(
					'class' => 'col-form-label ml-3 mr-2',
					'text' => '対象日時 : '
				), 
				'type' => 'date',
				'dateFormat' => 'YMD',
				'monthNames' => false,
				'timeFormat' => '24',
				'minYear' => date('Y') - 5,
				'maxYear' => date('Y'),
				'separator' => ' / ',
				'class'=>'form-control',
				'style' => 'display: inline; width: inherit !important;',
				'value' => $from_date,
				'div' => false
			));
			echo $this->Form->input('to_date', array(
				'label' => array(
					'class' => 'col-form-label ml-3 mr-2',
					'text' => '～'
				), 
				'type' => 'date',
				'dateFormat' => 'YMD',
				'monthNames' => false,
				'timeFormat' => '24',
				'minYear' => date('Y') - 5,
				'maxYear' => date('Y'),
				'separator' => ' / ',
				'class'=>'form-control',
				'style' => 'display: inline; width: inherit !important;',
				'value' => $to_date,
				'div' => false
			));
			echo '</div>';
			echo $this->Form->end();
		?>
	</div>
	<table cellpadding="0" cellspacing="0" class="table table-striped table-responsive-sm">
	<thead>
	<tr>
		<th nowrap><?php echo $this->Paginator->sort('course_id', 'コース'); ?></th>
		<th nowrap><?php echo $this->Paginator->sort('content_id', 'コンテンツ'); ?></th>
		<th nowrap><?php echo $this->Paginator->sort('User.name', '氏名'); ?></th>
		<th nowrap class="ib-col-center"><?php echo $this->Paginator->sort('score', '得点'); ?></th>
		<th class="ib-col-center" nowrap><?php echo $this->Paginator->sort('pass_score', '合格点'); ?></th>
		<th nowrap class="ib-col-center"><?php echo $this->Paginator->sort('is_passed', '結果'); ?></th>
		<th class="ib-col-center" nowrap><?php echo $this->Paginator->sort('understanding', '理解度'); ?></th>
		<th class="ib-col-center"><?php echo $this->Paginator->sort('study_sec', '学習時間'); ?></th>
		<th class="ib-col-datetime"><?php echo $this->Paginator->sort('created', '学習日時'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($records as $record): ?>
	<tr>
		<td><a href="javascript:openRecord(<?php echo h($record['Course']['id']); ?>, <?php echo h($record['User']['id']); ?>);"><?php echo h($record['Course']['title']); ?></a></td>
		<td><?php echo h($record['Content']['title']); ?>&nbsp;</td>
		<td><?php echo h($record['User']['name']); ?>&nbsp;</td>
		<td class="ib-col-center"><?php echo h($record['Record']['score']); ?>&nbsp;</td>
		<td class="ib-col-center"><?php echo h($record['Record']['pass_score']); ?>&nbsp;</td>
		<td nowrap class="ib-col-center"><a href="javascript:openTestRecord(<?php echo h($record['Content']['id']); ?>, <?php echo h($record['Record']['id']); ?>);"><?php echo Configure::read('record_result.'.$record['Record']['is_passed']); ?></a></td>
		<td nowrap class="ib-col-center"><?php echo h(Configure::read('record_understanding.'.$record['Record']['understanding'])); ?>&nbsp;</td>
		<td class="ib-col-center"><?php echo h(Utils::getHNSBySec($record['Record']['study_sec'])); ?>&nbsp;</td>
		<td class="ib-col-date"><?php echo h(Utils::getYMDHN($record['Record']['created'])); ?>&nbsp;</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?php echo $this->element('paging');?>
</div>
