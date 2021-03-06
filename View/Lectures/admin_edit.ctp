<?php echo $this->element('admin_menu');?>
<?php echo $this->Html->css( 'select2.min.css');?>
<?php echo $this->Html->script( 'select2.min.js');?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
	$(function (e) {
		$('#MemberMember').select2({
			placeholder:   "所属する生徒を選択して下さい。(複数選択可)", 
			closeOnSelect: <?php echo (Configure::read('close_on_select') ? 'true' : 'false'); ?>,
		});

		// パスワードの自動復元を防止
		setTimeout('$("#UserNewPassword").val("");', 500);
	});
<?php $this->Html->scriptEnd(); ?>
<div class="col-11 mx-auto bg-light">
<?php echo $this->Html->link(__('<< 戻る'), array('action' => 'index_2'))?>
	<div class="card bg-light">
		<div class="card-header">
			<?php echo ($this->action == 'admin_edit') ? __('編集') :  __('新規授業'); ?>
		</div>
		<div class="card-body">
			<?php echo $this->Form->create('Lecture', Configure::read('form_defaults_bs4')); ?>
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('lecture_name',	array('label' => __('管理側授業名')));
				echo $this->Form->input('st_lecture_name',	array('label' => __('生徒側授業名')));
				echo $this->Form->input('lecture_place',	array('label' => __('授業の場所')));
				
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
					'style' => 'width: 100%',
					'placeholder' => '2019/11/01
2019/11/02
のように入力してください'
				));
				echo $this->Form->input('Member',				array('label' => '受講生'));
				echo $this->Form->input('comment',		array(
					'label' => __('備考'),
					'type' => 'textarea',
    			'class' => '',
					'style' => 'width: 100%',
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