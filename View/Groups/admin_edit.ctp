<?php echo $this->element('admin_menu');?>
<?php echo $this->Html->css( 'select2.min.css');?>
<?php echo $this->Html->script( 'select2.min.js');?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
	$(function (e) {
		$('#CourseCourse').select2({placeholder: "受講するWebテストを選択して下さい。(複数選択可)", closeOnSelect: <?php echo (Configure::read('close_on_select') ? 'true' : 'false'); ?>,});
		$('#LectureLecture').select2({placeholder: "開講する授業を選択して下さい。(複数選択可)", closeOnSelect: <?php echo (Configure::read('close_on_select') ? 'true' : 'false'); ?>,});
		
	});
<?php $this->Html->scriptEnd(); ?>
<div class="admin-groups-edit col">
<?php echo $this->Html->link(__('<< 戻る'), array('action' => 'index'))?>
	<div class="card bg-light">
		<div class="card-header">
			<?php echo ($this->action == 'admin_edit') ? __('編集') :  __('新規キャンパス'); ?>
		</div>
		<div class="card-body">
			<?php echo $this->Form->create('Group', Configure::read('form_defaults_bs4')); ?>
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('title',	array('label' => __('キャンパス名')));
				echo $this->Form->input('Course',	array('label' => __('受講Webテスト'),		'size' => 20));
				echo $this->Form->input('Lecture',	array('label' => __('受講科目'),		'size' => 20));
				echo $this->Form->input('comment',	array('label' => __('備考')));
			?>
			<div class="form-group">
				<div class="col col-sm-9 col-sm-offset-3">
					<?php echo $this->Form->submit('保存', Configure::read('form_submit_defaults')); ?>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>