<?php echo $this->element('admin_menu');?>
<?php echo $this->Html->css( 'select2.min.css');?>
<?php echo $this->Html->script( 'select2.min.js');?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
	$(function (e) {
		$('#LectureStudents').select2({
			placeholder:   "所属する生徒を選択して下さい。(複数選択可)", 
			closeOnSelect: <?php echo (Configure::read('close_on_select') ? 'true' : 'false'); ?>,
		});

		// パスワードの自動復元を防止
		setTimeout('$("#UserNewPassword").val("");', 500);
	});
<?php $this->Html->scriptEnd(); ?>
<div class="admin-lecture-edit">
<?php echo $this->Html->link(__('<< 戻る'), array('action' => 'index_2'))?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo ($this->action == 'admin_edit') ? __('編集') :  __('新規授業'); ?>
		</div>
		<div class="panel-body">
			<?php echo $this->Form->create('Lecture', Configure::read('form_defaults')); ?>
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('lecture_name',	array('label' => __('授業名')));
				/*
				echo $this->Form->input('opened',	array(
					'type' => 'datetime',
					'dateFormat' => 'YMD',
					'monthNames' => false,
					'timeFormat' => '24',
					'separator' => ' - ',
					'label'=> '公開日時',
					'style' => 'width:initial; display: inline;'
				));
				*/
				echo $this->Form->input('docent_id',	array(
					'label' => __('担当講師'),
					'options'=> $docent_list, 
					'selected'=> $docent_list[$docent_id], 
					'empty' => '', 
					'required'=>false, 
					'class'=>'form-control'
				));
				echo $this->Form->input('lecture_date',array(
					'label' => __('授業日'),
    			'type' => 'textarea',
    			'class' => '',
					'style' => '',
					'placeholder' => '2019/11/01
2019/11/02
のように入力してください',
    			'value' => $enquete_inputted['Enquete']['before_false_reason']
				));
				echo $this->Form->input('comment',		array(
					'label' => __('備考'),
					'type' => 'textarea',
    			'class' => '',
					'style' => '',
				));
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